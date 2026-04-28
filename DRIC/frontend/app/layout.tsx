import type { Metadata } from "next";
import { Comfortaa } from "next/font/google";
import "./globals.css";

const comfortaa = Comfortaa({
  variable: "--font-comfortaa",
  subsets: ["latin"],
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
      <body className={`${comfortaa.variable} antialiased`}>
        {children}
      </body>
    </html>
  );
}