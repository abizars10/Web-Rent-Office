import { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import { City } from "../types/type";
import axios from "axios";
import OfficeCard from "../components/OfficeCard";
import Navbar from "../components/Navbar";

export default function CityDetails() {
  const { slug } = useParams<{ slug: string }>();
  const [city, setCity] = useState<City | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    axios
      .get(`http://127.0.0.1:8000/api/city/${slug}`, {
        headers: {
          "X-API-KEY": "as78dsh8",
        },
      })
      .then((response) => {
        setCity(response.data.data);
        setLoading(false);
      })
      .catch((error) => {
        setError(error);
        setLoading(false);
      });
  }, [slug]);

  if (loading) {
    return <p>Loading...</p>;
  }

  if (error) {
    return <p>Error loading: {error}</p>;
  }

  if (!city) {
    return <p>Category not found</p>;
  }

  const baseUrl = "http://127.0.0.1:8000/storage";

  return (
    <>
      <Navbar></Navbar>
      <header className="flex flex-col w-full">
        <section id="Hero-Banner" className="relative flex h-[434px]">
          <div id="Hero-Text" className="relative flex flex-col w-full max-w-[650px] h-fit rounded-[30px] border border-[#E0DEF7] p-10 gap-[30px] bg-white mt-[70px] ml-[calc((100%-1130px)/2)] z-10">
            <h1 className="font-extrabold text-[50px] leading-[60px]">
              Great Office in <br /> <span className="text-[#0D903A]">{city.name} City</span>
            </h1>
            <p className="text-lg leading-8 text-[#000929]">Kantor yang tepat dapat memberikan impact pekerjaan menjadi lebih baik dan sehat dalam tumbuhkan karir.</p>
          </div>
          <div id="Hero-Image" className="absolute right-0 w-[calc(100%-((100%-1130px)/2)-305px)] h-[434px] rounded-bl-[40px] overflow-hidden">
            <img src={`${baseUrl}/${city.photo}`} className="w-full h-full object-cover" alt="hero background" />
          </div>
        </section>
      </header>
      <section id="Fresh-Space" className="flex flex-col gap-[30px] w-full max-w-[1130px] mx-auto mt-[70px] mb-[120px]">
        <h2 className="font-bold text-[32px] leading-[48px] text-nowrap">Browse Offices</h2>
        <div className="grid grid-cols-3 gap-[30px]">
          {city.officeSpaces.map((office) => (
            <Link key={office.id} to={`/office/${office.slug}`}>
              <OfficeCard office={office}></OfficeCard>
            </Link>
          ))}
        </div>
      </section>
    </>
  );
}
