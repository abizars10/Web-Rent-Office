<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTransactionResource\Pages;
use App\Filament\Resources\BookingTransactionResource\RelationManagers;
use App\Models\BookingTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Twilio\Rest\Client;

class BookingTransactionResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('booking_trx_id')->required()->maxLength(255),
            TextInput::make('phone_number')->required()->maxLength(255),
            TextInput::make('total_amount')->required()->numeric()->prefix('IDR'),
            TextInput::make('duration')->required()->numeric()->prefix('Days'),
            DatePicker::make('started_at')->required(),
            DatePicker::make('ended_at')->required(),
            Select::make('is_paid')
                ->options([
                    true => 'Paid',
                    false => 'Not Paid',
                ])
                ->required(),
            Select::make('office_space_id')->relationship('officeSpace', 'name')->searchable()->preload()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([TextColumn::make('booking_trx_id')->searchable(), TextColumn::make('name')->searchable(), TextColumn::make('officeSpace.name'), TextColumn::make('started_at')->date(), IconColumn::make('is_paid')->boolean()->trueColor('success')->falseColor('danger')->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle')->label('Sudah Bayar?')])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->action(function (BookingTransaction $record) {
                        $record->is_paid = true;
                        $record->save();

                        // trigger the custom notification
                        Notification::make()->title('Booking Approve')->success()->body('The booking has been successfully approved.')->send();

                        // find your account SID and Auth Token at twilio.com/console
                        // and set the environment variables. See http://twil.io/secure
                        $sid = getenv("TWILIO_ACCOUNT_SID");
                        $token = getenv("TWILIO_AUTH_TOKEN");
                        $twilio = new Client($sid, $token);

                        // create the message with line breaks
                        $messageBody = "Hi {$record->name}, pemesanan Anda dengan kode {$record->booking_trx_id} sudah terbayar penuh.\n\n";
                        $messageBody .= "Silahkan datang kepada lokasi kantor {$record->officeSpace->name} untuk mulai menggunakan ruangna kerja tersebut.\n\n";
                        $messageBody .= "Jika Anda memiliki pertanyaan silahkan menghubungi CS kami di buildwithangga.com/contact-us.";

                        $message = $twilio->messages->create(
                            "+{$record->phone_number}",
                            [
                                "body" => $messageBody,
                                "from" => getenv("TWILIO_PHONE_NUMBER"),
                            ]
                            );
                    })
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (BookingTransaction $record) => !$record->is_paid),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingTransactions::route('/'),
            'create' => Pages\CreateBookingTransaction::route('/create'),
            'edit' => Pages\EditBookingTransaction::route('/{record}/edit'),
        ];
    }
}
