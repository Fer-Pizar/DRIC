export default function Footer() {
  const socialLinks = [
    {
      name: "LinkedIn",
      href: "https://bo.linkedin.com/school/umssboloficial/?trk=public_post_feed-actor-image",
      icon: "/images/social/linkedin.png",
    },
    {
      name: "Facebook",
      href: "https://www.facebook.com/UMSS.DRIC",
      icon: "/images/social/facebook.png",
    },
    {
      name: "X",
      href: "https://x.com/UmssBolOficial",
      icon: "/images/social/x.png",
    },
    {
      name: "Instagram",
      href: "https://www.instagram.com/umss.dric/",
      icon: "/images/social/instagram.png",
    },
    {
      name: "YouTube",
      href: "https://www.youtube.com/c/UniversidadMayordeSanSimonOficial",
      icon: "/images/social/youtube.png",
    },
  ];
  const umssUrl = "https://www.umss.edu.bo/";

  return (
    <footer
      style={{ backgroundColor: "#001935" }}
      className="px-6 py-10 font-[Comfortaa] text-white sm:px-10 sm:py-5 md:px-14 lg:px-20"
    >
      <div className="mx-auto flex max-w-7xl flex-col">
        <div className="flex flex-col items-center justify-between gap-7 text-center sm:gap-5 md:flex-row md:text-left">
          <p className="text-sm leading-6 text-white/68 sm:text-base">
            Todos los derechos reservados © 2026
          </p>

          <div className="flex items-center justify-center gap-4 sm:gap-5">
            {socialLinks.map((social) => (
              <a
                key={social.name}
                href={social.href}
                aria-label={social.name}
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex h-8 w-8 items-center justify-center transition hover:scale-105 hover:opacity-100 sm:h-8 sm:w-8"
              >
                <img
                  src={social.icon}
                  alt=""
                  className="max-h-full max-w-full object-contain opacity-60 grayscale brightness-125"
                />
              </a>
            ))}
          </div>
        </div>

        <div className="my-8 h-px w-full bg-white/58 sm:my-5" />

        <div className="grid items-start gap-10 sm:gap-8 md:grid-cols-[150px_1fr] lg:grid-cols-[170px_1fr]">
          <div className="flex justify-center md:-ml-4 md:justify-start lg:-ml-6">
            <a href={umssUrl} target="_blank" rel="noopener noreferrer" aria-label="Universidad Mayor de San Simón">
              <img
                src="/images/brand/umss-triangle.png"
                alt="UMSS"
                className="h-auto w-24 opacity-25 transition hover:opacity-50 sm:w-28 md:w-36 lg:w-40"
              />
            </a>
          </div>

          <div className="text-center md:text-left">
            <h2 className="text-base font-normal uppercase leading-relaxed tracking-[0.01em] text-white sm:text-lg">
              Dirección de Relaciones Internacionales y Convenios
            </h2>
            <address className="mt-2 not-italic text-sm leading-7 text-white sm:text-base">
              <p>Av. Ballivián N. 591 esq. Reza, Cochabamba, Bolivia</p>
              <p>Edif. Mariscal Andrés de Santa Cruz</p>
            </address>
          </div>
        </div>

        <div className="flex justify-center pt-7 sm:pt-10 md:pt-0 lg:-mt-15">
          <img
            src="/images/brand/umss-wordmark.png"
            alt="Universidad Mayor de San Simón. Ciencia y Conocimiento desde 1832"
            className="h-auto w-full max-w-[939px] opacity-20"
          />
        </div>
      </div>
    </footer>
  );
}
