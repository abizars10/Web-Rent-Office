import OfficeCard from "../components/OfficeCard";

export default function BrowseOfficeWrapper() {
  return (
    <section id="Fresh-Space" className="flex flex-col gap-[30px] w-full max-w-[1130px] mx-auto mt-[100px] mb-[120px]">
      <h2 className="font-bold text-[32px] leading-[48px] text-nowrap text-center">
        Browse Our Fresh Space.
        <br />
        For Your Better Productivity.
      </h2>
      <div className="grid grid-cols-3 gap-[30px]">
        <OfficeCard></OfficeCard>
      </div>
    </section>
  );
}
