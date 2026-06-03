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
    <main className="min-h-screen overflow-x-hidden bg-[#020617] text-white">
      <Header />

      <section className="relative isolate px-5 pb-20 pt-36 md:px-10 lg:px-12">
        <div className="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_top_left,rgba(181,18,27,0.42),transparent_34%),radial-gradient(circle_at_top_right,rgba(22,65,148,0.50),transparent_36%),linear-gradient(135deg,#020617_0%,#08111f_45%,#12070a_100%)]" />
        <div className="absolute left-1/2 top-24 -z-10 h-[420px] w-[420px] -translate-x-1/2 rounded-full bg-white/10 blur-[140px]" />

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

      <section className="bg-[#f8fafc] px-5 py-20 text-slate-950 md:px-10 lg:px-12">
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
              sx={{
                borderRadius: "32px",
                border: "1px solid rgba(15,23,42,0.08)",
                boxShadow: "0 24px 70px rgba(15,23,42,0.08)",
                overflow: "hidden",
              }}
            >
              <div className="p-8">
                <div className="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#020617] text-white">
                  <LocationOnRoundedIcon />
                </div>

                <p className="text-sm font-bold uppercase tracking-[0.22em] text-[#b5121b]">
                  {labels.address}
                </p>

                <h2 className="mt-4 text-2xl font-bold tracking-[-0.04em]">
                  DRIC
                </h2>

                <p className="mt-4 text-sm leading-7 text-slate-600">
                  {labels.addressText}
                </p>
              </div>
            </Card>

            <Card
              sx={{
                borderRadius: "32px",
                background: "#020617",
                color: "white",
                boxShadow: "0 24px 70px rgba(15,23,42,0.18)",
                overflow: "hidden",
              }}
            >
              <div className="p-8">
                <PublicRoundedIcon sx={{ color: "#ef4444", fontSize: 38 }} />
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
            sx={{
              borderRadius: "36px",
              border: "1px solid rgba(15,23,42,0.08)",
              boxShadow: "0 30px 90px rgba(15,23,42,0.12)",
              overflow: "hidden",
            }}
          >
            <div className="bg-white p-6 md:p-8">
              <div className="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                  <p className="text-sm font-bold uppercase tracking-[0.25em] text-[#164194]">
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
                    background: "linear-gradient(135deg,#b5121b,#e1242f)",
                    textTransform: "none",
                    fontWeight: 800,
                    boxShadow: "0 14px 34px rgba(181,18,27,0.22)",
                  }}
                >
                  {labels.openMap}
                </Button>
              </div>

              <div className="overflow-hidden rounded-[28px] border border-slate-200">
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
      sx={{
        borderRadius: "32px",
        border: "1px solid rgba(15,23,42,0.08)",
        boxShadow: "0 24px 70px rgba(15,23,42,0.08)",
        overflow: "hidden",
      }}
    >
      <a href={href} className="block p-8 transition hover:bg-slate-50">
        <div className="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-[#020617] text-white">
          {icon}
        </div>

        <p className="text-sm font-bold uppercase tracking-[0.22em] text-[#b5121b]">
          {title}
        </p>

        <p className="mt-4 text-xl font-bold text-[#164194]">{content}</p>
      </a>
    </Card>
  );
}