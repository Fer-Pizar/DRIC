'use client';

import {useState} from 'react';
import {Menu, X} from 'lucide-react';
import {useTranslations} from 'next-intl';
import MobileMenu from './MobileMenu';

export default function Header() {
  const [open, setOpen] = useState(false);
  const t = useTranslations('nav');

  const items = [
    t('home'),
    t('presentation'),
    t('agreements'),
    t('projects'),
    t('mobility'),
    t('memberships'),
    t('events'),
    t('regulations'),
    t('reports'),
    t('contact')
  ];

  return (
    <>
      <header className="fixed inset-x-0 top-0 z-50">
        <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 md:px-8 lg:px-12">
          <div className="flex items-center gap-3">
            <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-400/20 ring-1 ring-cyan-300/30">
              <span className="text-xl font-bold text-cyan-300">DR</span>
            </div>
            <span className="text-2xl font-extrabold tracking-tight text-cyan-300">
              DRIC
            </span>
          </div>

          <button
            type="button"
            onClick={() => setOpen(true)}
            className="rounded-xl p-2 text-white/90 transition hover:bg-white/5"
            aria-label="Open menu"
          >
            <Menu className="h-8 w-8" />
          </button>
        </div>
      </header>

      <MobileMenu open={open} onClose={() => setOpen(false)} items={items} />
    </>
  );
}