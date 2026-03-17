import {useTranslations} from 'next-intl';

export default function HeroSection() {
  const t = useTranslations('hero');

  return (
    <section className="grid-overlay relative overflow-hidden px-4 pb-20 pt-28 md:px-8 md:pb-28 md:pt-36 lg:px-12 lg:pb-32 lg:pt-40">
      <div className="mx-auto flex max-w-6xl flex-col items-center text-center">
        <p className="mb-6 text-xs font-semibold uppercase tracking-[0.28em] text-cyan-300 md:text-sm">
          {t('eyebrow')}
        </p>

        <h1 className="max-w-5xl text-5xl font-black leading-none tracking-tight md:text-7xl lg:text-8xl">
          <span className="block text-white">{t('titleLine1')}</span>
          <span className="text-gradient block">{t('titleLine2')}</span>
        </h1>

        <p className="mt-6 max-w-4xl text-lg leading-relaxed text-white/70 md:text-2xl">
          {t('subtitle')}
        </p>

        <div className="mt-10 flex w-full max-w-2xl flex-col gap-4 sm:flex-row sm:justify-center">
          <button className="rounded-full bg-gradient-to-r from-indigo-500 to-violet-500 px-8 py-4 text-lg font-semibold text-white shadow-[0_0_40px_rgba(139,92,246,0.35)] transition hover:scale-[1.02]">
            {t('ctaPrimary')}
          </button>

          <button className="rounded-full border border-white/20 bg-white/5 px-8 py-4 text-lg font-semibold text-white transition hover:bg-white/10">
            {t('ctaSecondary')}
          </button>
        </div>
      </div>
    </section>
  );
}