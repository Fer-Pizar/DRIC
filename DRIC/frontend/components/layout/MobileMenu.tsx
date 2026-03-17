'use client';

import {X} from 'lucide-react';

type Props = {
  open: boolean;
  onClose: () => void;
  items: string[];
};

export default function MobileMenu({open, onClose, items}: Props) {
  return (
    <div
      className={`fixed inset-0 z-[60] bg-[#040611]/95 backdrop-blur-md transition ${
        open ? 'pointer-events-auto opacity-100' : 'pointer-events-none opacity-0'
      }`}
    >
      <div className="flex items-center justify-between px-4 py-6 md:px-8">
        <span className="text-3xl font-extrabold text-cyan-300">DRIC</span>

        <button
          type="button"
          onClick={onClose}
          className="rounded-xl p-2 text-white"
          aria-label="Close menu"
        >
          <X className="h-8 w-8" />
        </button>
      </div>

      <nav className="px-4 md:px-8">
        <ul className="border-t border-white/10">
          {items.map((item) => (
            <li key={item} className="border-b border-white/10 py-6 text-2xl font-semibold uppercase tracking-wide text-white/95 md:text-3xl">
              {item}
            </li>
          ))}
        </ul>
      </nav>
    </div>
  );
}