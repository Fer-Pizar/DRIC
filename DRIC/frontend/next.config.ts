import createNextIntlPlugin from 'next-intl/plugin';
import type {NextConfig} from 'next';

const withNextIntl = createNextIntlPlugin();

const apiBase = process.env.NEXT_PUBLIC_API_BASE_URL ?? 'http://127.0.0.1:8000/api';
const backendBase = process.env.NEXT_PUBLIC_BACKEND_URL ?? apiBase.replace(/\/api\/?$/, '');
const backendUrl = new URL(backendBase);
const backendPattern = {
  protocol: backendUrl.protocol.replace(':', '') as 'http' | 'https',
  hostname: backendUrl.hostname,
  port: backendUrl.port,
  pathname: '/storage/**'
};

const nextConfig: NextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: 'http',
        hostname: '127.0.0.1',
        port: '8000',
        pathname: '/storage/**'
      },
      {
        protocol: 'http',
        hostname: 'localhost',
        port: '8000',
        pathname: '/storage/**'
      },
      {
        ...backendPattern
      }
    ]
  }
};

export default withNextIntl(nextConfig);
