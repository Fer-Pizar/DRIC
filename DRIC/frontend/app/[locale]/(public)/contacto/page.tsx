import Header from "@/components/layout/Header";
import Footer from "@/components/layout/Footer";
import Card from "@mui/material/Card";
import Button from "@mui/material/Button";
import PhoneRoundedIcon from "@mui/icons-material/PhoneRounded";
import EmailRoundedIcon from "@mui/icons-material/EmailRounded";
import LocationOnRoundedIcon from "@mui/icons-material/LocationOnRounded";
import OpenInNewRoundedIcon from "@mui/icons-material/OpenInNewRounded";
import PublicRoundedIcon from "@mui/icons-material/PublicRounded";

type Props = {
  params: Promise<{ locale: string }>;
};

export default async function ContactoPage({ params }: Props) {
  const { locale } = await params;
  const isEnglish = locale === "en";

  const labels = {
    badge: isEnglish ? "Contact" : "Contacto",
    title: isEnglish ? "Contact DRIC" : "Contacto",
    intro: isEnglish
      ? "Get in touch with the Directorate of International Relations and Agreements of Universidad Mayor de San Simón."
      : "Comunícate con la Dirección de Relaciones Internacionales y Convenios de la Universidad Mayor de San Simón.",
    phone: isEnglish ? "Phone" : "Teléfonos",
    email: isEnglish ? "Email" : "Correo electrónico",
    address: isEnglish ? "Address" : "Dirección",
    addressText: isEnglish
      ? "Av. Ballivián N. 591 Esq. Reza, Edif. Mariscal Andrés de Santa Cruz (Rectorado), Mezzanine, Cochabamba, Bolivia."
      : "Av. Ballivián N. 591 esq. Reza, Edif. Mariscal Andrés de Santa Cruz (Rectorado), Mezanine, Cochabamba, Bolivia.",
    mapTitle: isEnglish ? "Location map" : "Mapa de ubicación",
    openMap: isEnglish ? "Open in Google Maps" : "Abrir en Google Maps",
    social: isEnglish ? "Institutional channels" : "Canales institucionales",
  };

  return (
    <main className="dric-theme-page dric-contact-page min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="dric-contact-hero relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="mx-auto max-w-7xl">
          <p className="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white/80 backdrop-blur">
            DRIC · UMSS
          </p>

          <h1 className="text-5xl font-light uppercase leading-[0.9] tracking-[-0.07em] md:text-7xl lg:text-8xl">
            {labels.title}
          </h1>

          <p className="mt-8 max-w-3xl text-base leading-8 text-white/70 md:text-lg">
            {labels.intro}
          </p>
        </div>
      </section>

      <section className="dric-contact-section relative isolate overflow-hidden px-5 py-20 text-white md:px-10 lg:px-12">
        <div className="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[0.85fr_1.15fr]">
          <div className="space-y-6">
            <ContactCard
              icon={<PhoneRoundedIcon />}
              title={labels.phone}
              content="(+591) 4 4524779"
              href="tel:+59144524779"
            />

            <ContactCard
              icon={<EmailRoundedIcon />}
              title={labels.email}
              content="rrii@umss.edu.bo"
              href="mailto:rrii@umss.edu.bo"
            />

            <Card
              className="dric-contact-card"
              sx={{
                borderRadius: "32px",
                background: "rgba(255,255,255,0.06)",
                border: "1px solid rgba(255,255,255,0.10)",
                boxShadow: "0 24px 70px rgba(0,0,0,0.24)",
                color: "white",
                overflow: "hidden",
              }}
            >
              <div className="p-8">
                <div className="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-cyan-300">
                  <LocationOnRoundedIcon />
                </div>

                <p className="text-sm font-bold uppercase tracking-[0.22em] text-[#E30613]">
                  {labels.address}
                </p>

                <h2 className="mt-4 text-2xl font-bold tracking-[-0.04em]">
                  DRIC
                </h2>

                <p className="mt-4 text-sm leading-7 text-white/62">
                  {labels.addressText}
                </p>
              </div>
            </Card>

            <Card
              className="dric-contact-card"
              sx={{
                borderRadius: "32px",
                background: "rgba(255,255,255,0.06)",
                color: "white",
                border: "1px solid rgba(255,255,255,0.10)",
                boxShadow: "0 24px 70px rgba(0,0,0,0.24)",
                overflow: "hidden",
              }}
            >
              <div className="p-8">
                <PublicRoundedIcon sx={{ color: "#E30613", fontSize: 38 }} />
                <h2 className="mt-5 text-2xl font-bold tracking-[-0.04em]">
                  {labels.social}
                </h2>
                <p className="mt-4 text-sm leading-7 text-white/65">
                  Facebook · X · YouTube · Instagram · LinkedIn
                </p>
              </div>
            </Card>
          </div>

          <Card
            className="dric-contact-map-card"
            sx={{
              borderRadius: "36px",
              background: "rgba(255,255,255,0.06)",
              border: "1px solid rgba(255,255,255,0.10)",
              boxShadow: "0 30px 90px rgba(0,0,0,0.24)",
              color: "white",
              overflow: "hidden",
            }}
          >
            <div className="dric-contact-map-inner bg-white/[0.06] p-6 md:p-8">
              <div className="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                  <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#003770]">
                    UMSS · Cochabamba
                  </p>
                  <h2 className="mt-3 text-3xl font-semibold tracking-[-0.04em]">
                    {labels.mapTitle}
                  </h2>
                </div>

                <Button
                  href="https://www.google.com/maps/search/?api=1&query=Rectorado+UMSS+Cochabamba+Bolivia"
                  target="_blank"
                  variant="contained"
                  endIcon={<OpenInNewRoundedIcon />}
                  sx={{
                    borderRadius: "999px",
                    px: 3,
                    py: 1.2,
                    background: "linear-gradient(135deg,#E30613,#E30613)",
                    textTransform: "none",
                    fontWeight: 800,
                    boxShadow: "0 14px 34px rgba(227,6,19,0.22)",
                  }}
                >
                  {labels.openMap}
                </Button>
              </div>

              <div className="overflow-hidden rounded-[28px] border border-white/10">
                <iframe
                  title="DRIC UMSS Google Maps"
                  src="https://www.google.com/maps?q=Rectorado%20UMSS%20Cochabamba%20Bolivia&output=embed"
                  className="h-[790px] w-full border-0"
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                />
              </div>
            </div>
          </Card>
        </div>
      </section>

      <Footer />
    </main>
  );
}

function ContactCard({
  icon,
  title,
  content,
  href,
}: {
  icon: React.ReactNode;
  title: string;
  content: string;
  href: string;
}) {
  return (
    <Card
      className="dric-contact-card"
      sx={{
        borderRadius: "32px",
        background: "rgba(255,255,255,0.06)",
        border: "1px solid rgba(255,255,255,0.10)",
        boxShadow: "0 24px 70px rgba(0,0,0,0.24)",
        color: "white",
        overflow: "hidden",
      }}
    >
      <a href={href} className="block p-8 transition hover:bg-white/[0.06]">
        <div className="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-cyan-300">
          {icon}
        </div>

        <p className="text-sm font-bold uppercase tracking-[0.22em] text-[#E30613]">
          {title}
        </p>

        <p className="mt-4 text-xl font-bold text-cyan-300">{content}</p>
      </a>
    </Card>
  );
}
