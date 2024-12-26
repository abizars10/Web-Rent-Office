import { Swiper, SwiperSlide } from "swiper/react";
import CityCard from "../components/CityCard";

export default function BrowseCityWrapper() {
  return (
    <section id="Cities" className="flex flex-col gap-[30px] mt-[100px]">
      <div className="w-full max-w-[1130px] mx-auto flex items-center justify-between">
        <h2 className="font-bold text-[32px] leading-[48px] text-nowrap">
          You Can Choose <br />
          Our Favorite Cities
        </h2>
        <a href="#" className="rounded-full rounded-full py-3 px-5 bg-white font-bold">
          Explore All City
        </a>
      </div>
      <div className="swiper w-full">
        <div className="swiper-wrapper">
          <Swiper direction="horizontal" spaceBetween={30} slidesPerView="auto" slidesOffsetAfter={30} slidesOffsetBefore={30}>
            <div className="swiper-slide !w-fit first-of-type:pl-[calc((100%-1130px-60px)/2)] last-of-type:pr-[calc((100%-1130px-60px)/2)]">
              <a href="city-details.html" className="card">
                <div className="relative flex shrink-0 w-[230px] h-[300px] rounded-[20px] overflow-hidden">
                  <div className="relative flex flex-col justify-end w-full h-full p-5 gap-[2px] bg-[linear-gradient(180deg,_rgba(0,0,0,0)_49.87%,_rgba(0,0,0,0.8)_100%)] z-10">
                    <h3 className="font-bold text-xl leading-[30px] text-white">Jakarta Pusat</h3>
                    <p className="text-white">189 Offices</p>
                  </div>
                  <img src="/assets/images/thumbnails/thumbnails-2.png" className="absolute w-full h-full object-cover" alt="thumbnails" />
                </div>
              </a>
            </div>
            <SwiperSlide className="!w-fit first-of-type:pl-[calc((100%-1130px-60px)/2)] last-of-type:pr-[calc((100%-1130px-60px)/2)]">
              <CityCard></CityCard>
            </SwiperSlide>
          </Swiper>
        </div>
      </div>
    </section>
  );
}
