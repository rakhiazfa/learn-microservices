import truncate from "@/utils/truncate";
import { Card, CardBody, CardHeader, Image } from "@nextui-org/react";
import { Link } from "react-router-dom";

const news = [
    {
        title: "Musik Ciptaan Warga Merdekalio Membuat Heboh Kota Bandung",
    },
    {
        title: "Kedatangan Ridwan Kamil Di Sambut Hangat Oleh Warga",
    },
    {
        title: "Warga Sangat Berantusias Membersihkan Desa Merdekalio",
    },
    {
        title: "Website Buatan Rakhi Sangat Membantu Aktifitas Warga",
    },
    {
        title: "Warga Gembira Menyambut Bulan Ramadhan Yang Akan Datang",
    },
    {
        title: "Kemenangan Persib Bandung Melawan Persija Dirayakan Oleh Warga Merdekalio",
    },
    {
        title: "Keseruan Warga Merayakan Hari Kemerdekaan Indonesia Ke-77",
    },
    {
        title: "Pembangunan Masjid Berjalan Dengan Sangat Lancar",
    },
];

const Home = () => {
    return (
        <main>
            <section id="hero" className="py-5">
                <div className="w-full h-[450px] bg-gray-300"></div>
            </section>
            <section id="news" className="py-5">
                <div className="app-container">
                    <h1 className="text-2xl font-semibold tracking-wide mb-7 ml-3">
                        Berita Terkini
                    </h1>
                    <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        {news.map(({ title }, index) => (
                            <Link key={index} to="/">
                                <Card className="py-2">
                                    <CardHeader className="flex-col items-start px-4 py-2">
                                        <Image
                                            alt="Card background"
                                            className="object-cover rounded-xl"
                                            src="https://nextui.org/images/hero-card-complete.jpeg"
                                            width="100%"
                                        />
                                    </CardHeader>
                                    <CardBody className="h-[125px] flex flex-col justify-between px-5 py-2">
                                        <h4 className="text-[1.1rem] font-semibold leading-6">
                                            {truncate(title, 50)}
                                        </h4>
                                        <div className="flex items-center mt-3">
                                            <span className="text-xs">
                                                20 May 2024
                                            </span>
                                        </div>
                                    </CardBody>
                                </Card>
                            </Link>
                        ))}
                    </div>
                </div>
            </section>
        </main>
    );
};

export default Home;
