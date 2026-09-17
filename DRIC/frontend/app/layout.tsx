import type { Metadata } from "next";
import { Comfortaa, Poiret_One } from "next/font/google";
import "./globals.css";

const comfortaa = Comfortaa({
  variable: "--font-comfortaa",
  subsets: ["latin"],
});

const poiretOne = Poiret_One({
  variable: "--font-poiret-one",
  subsets: ["latin"],
  weight: "400",
});

export const metadata: Metadata = {
  title: "DRIC",
  description: "Dirección de Relaciones Internacionales y Convenios",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="es" suppressHydrationWarning>
      <body className={`${comfortaa.variable} ${poiretOne.variable} antialiased`}>
        {children}
      </body>
    </html>
  );
}
