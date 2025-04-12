// resources/js/main.jsx
import React from 'react';
import ReactDOM from 'react-dom/client';
import '../css/app.css';
import Preloader from './Preloader';

const rootElement = document.getElementById('root');

// Ambil value dari atribut data-page
const page = rootElement?.dataset.page || 'notfound';
const subTitle = rootElement?.dataset.subtitle || '';
const title = rootElement?.dataset.title || '';

import NotFoundPage from './pages/404';
const pages = {
  Prediksi: React.lazy(() => import('./pages/prediksi')),
  Laporan: React.lazy(() => import('./pages/laporan')),
  History: React.lazy(() => import('./pages/history')),
};

// Komponen fallback kalo gak ketemu
const NotFound = () => <NotFoundPage/>;

// Pilih komponen sesuai dengan data-page
const PageComponent = pages[page] || NotFound;

ReactDOM.createRoot(rootElement).render(
  <React.StrictMode>
    <React.Suspense fallback={<Preloader/>}>
      <PageComponent title={title} subTitle={subTitle} />
    </React.Suspense>
  </React.StrictMode>
);
