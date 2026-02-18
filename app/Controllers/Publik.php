<?php

namespace App\Controllers;

use App\Models\AgenModel;
use App\Models\SlideshowModel;
use App\Models\LayananModel;
use App\Models\BeritaModel;
use App\Models\MenuModel;
use App\Models\VisitModel;
use App\Models\PagesModel;
use App\Models\SettingModel;
use App\Models\PegawaiModel;
use App\Models\VideoModel;
use App\Models\DokumenModel;
use GuzzleHttp\Client;
use DiDom\Document;
use CodeIgniter\Exceptions\PageNotFoundException;


class Publik extends BaseController
{
    private $models;

    public function __construct() {
        $this->models = [
            'slideshow' => new SlideshowModel(),
            'layanan' => new LayananModel(),
            'berita' => new BeritaModel(),
            'dokumen' => new DokumenModel(),
            'menu' => new MenuModel(),
            'visit' => new VisitModel(),
            'pages' => new PagesModel(),
            'pegawai' => new PegawaiModel(),
            'setting' => new SettingModel(),
            'video' => new VideoModel(),
            'agen' => new AgenModel(),
        ];
        $this->db = \Config\Database::connect();
    }

    public function home(){
        $data = $this->getDefaultData([
            'slider' => $this->models['slideshow']->findAll(),
            'layanan' => $this->models['layanan']->orderBy('created_at', 'DESC')->findAll(6),
            'berita' => $this->models['berita']->where('jenis', 'berita')->orderBy('created_at', 'DESC')->findAll(4),
            'video' => $this->models['video']->orderBy('created_at', 'DESC')->findAll(3),
            'dokumen' => $this->models['dokumen']->orderBy('created_at', 'DESC')->findAll(3),
            'agen' => $this->models['agen']->orderBy('created_at', 'ASC')->findAll(),
            'page' => $this->models['pages']->findFeatured(),
            'berita_2' => $this->models['berita']->where('jenis', 'berita')->orderBy('created_at', 'DESC')->findAll(5,4),
            'pengumuman' => $this->models['berita']->where('jenis', 'pengumuman')->orderBy('created_at', 'DESC')->findAll(5),
            // 'siaran_pers' => $this->models['berita']->where('jenis', 'siaran_pers')->orderBy('created_at', 'DESC')->findAll(5)
        ]);
        // pr($data);
        return view('index', $data);
    }

    private function getDefaultData(array $additionalData = []) {
        return array_merge($this->dataSetting, $additionalData, [
            'visitor' => $this->getCountVisitor(),
            'navbar' => $this->getNavbar(),
            'menu' => $this->models['menu']->getMenuGroupingWithGrup(),
        ]);
    }

    public function dataBeritaKejagung() {
        $url = "https://kejaksaan.go.id/conference/news";
    
        try {
            // Membuat HTTP client
            $client = new Client();
    
            // Kirim permintaan GET ke URL
            $response = $client->request('GET', $url);
    
            if ($response->getStatusCode() === 200) {
                $htmlContent = $response->getBody()->getContents();
    
                // Parse HTML menggunakan DiDOM
                $document = new Document($htmlContent);
    
                // Temukan artikel-artikel berdasarkan elemen yang sesuai (misalnya <article> atau class 'post')
                $articles = $document->find('article.post');
    
                $schedule = [];
                $topArticles = array_slice($articles, 0, 5); // Ambil 5 artikel teratas
    
                foreach ($topArticles as $article) {
                    // Ambil judul, link, deskripsi dari artikel
                    $titleElement = $article->find('h2 a');
                    $link = $titleElement[0]->getAttribute('href');
                    $title = trim($titleElement[0]->text());
    
                    // Ambil deskripsi
                    $description = trim($article->find('p.mb-0')[0]->text());
    
                    // Ambil tanggal (mengambil elemen <span> dengan class atau struktur yang sesuai)
                    $dateElement = $article->find('.post-meta span');
                    $date = null;
                    foreach ($dateElement as $span) {
                        if (strpos($span->text(), '-') !== false) {
                            $date = trim($span->text());
                            break;
                        }
                    }
    
                    // Tambahkan data artikel ke dalam array
                    $schedule[] = [
                        'title' => $title,
                        'link' => $link,
                        'description' => $description,
                        'date' => $date,
                    ];
                }
    
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data berhasil diambil.',
                    'data' => $schedule
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mendapatkan data dari server.',
                    'data' => []
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

    private function getRssItems($url) {
        // Inisialisasi cURL
        $ch = curl_init();
        
        // Set opsi cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout jika perlu
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Untuk mengikuti redirect jika ada
        
        // Eksekusi cURL dan simpan hasilnya
        $rssContent = curl_exec($ch);
        
        // Cek jika cURL gagal
        if ($rssContent === false) {
            curl_close($ch);
            return [];
        }
    
        // Tutup cURL setelah selesai
        curl_close($ch);
    
        // Proses XML
        $xml = simplexml_load_string($rssContent);
        if ($xml === false) {
            return [];
        }
    
        // Ambil data item RSS
        $rssItems = [];
        foreach ($xml->channel->item as $item) {
            $rssItems[] = [
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'description' => (string) $item->description,
                'pubDate' => (string) $item->pubDate,
            ];
        }
    
        // Kembalikan hanya 5 item pertama
        return array_slice($rssItems, 0, 5);
    }
    

    public function dynamicView($viewName, $additionalData = []) {
        $data = $this->getDefaultData($additionalData);
        return view("publik/$viewName", $data);
    }

    public function beranda(){
        return $this->dynamicView('beranda', [
            'slider' => $this->models['slideshow']->findAll(),
            'layanan' => $this->models['layanan']->orderBy('created_at', 'DESC')->findAll(6),
            'berita' => $this->models['berita']->orderBy('created_at', 'DESC')->findAll(4),
        ]);
    }

    public function tentang_kejaksaan(){
        return $this->beranda(); // Shares the same logic as 'beranda'
    }

    public function pegawai($jenis){
        $pegawaiTypes = [
            'hakim' => 'Hakim',
            'ppnpn' => 'Pegawai Pemerintah Non Pegawai Negeri',
            'panitera' => 'Kepaniteraan',
            'sekretariat' => 'Kesekretariatan',
        ];

        if (!isset($pegawaiTypes[$jenis])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->dynamicView('pegawai', [
            'label' => $pegawaiTypes[$jenis],
            'pegawai' => $this->models['pegawai']->getPegawaiByJenis($jenis),
        ]);
    }

    public function layanan_publik(){
        return $this->beranda(); // Shares similar logic as 'beranda'
    }

    public function layanan_hukum(){
        return $this->beranda(); // Shares similar logic as 'beranda'
    }

    public function berita(){
        return $this->dynamicView('berita', [
            'berita' => $this->models['berita']->where('jenis', 'berita')->paginate(9),
            'pager' => $this->models['berita']->pager,
        ]);
    }

    public function siaran_pers(){
        return $this->dynamicView('siaran_pers', [
            'berita' => $this->models['berita']->where('jenis', 'siaran_pers')->paginate(9),
            'pager' => $this->models['berita']->pager,
        ]);
    }

    public function pengumuman(){
        return $this->dynamicView('pengumuman', [
            'berita' => $this->models['berita']->where('jenis', 'pengumuman')->paginate(9),
            'pager' => $this->models['berita']->pager,
        ]);
    }

    public function video(){
        return $this->dynamicView('video', [
            'video' => $this->models['video']->paginate(9),
            'pager' => $this->models['video']->pager,
        ]);
    }

    public function dokumen(){
        return $this->dynamicView('dokumen', [
            'dokumen' => $this->models['dokumen']->paginate(9),
            'pager' => $this->models['dokumen']->pager,
        ]);
    }

    public function beritaDetail($slug)
    {
        // Cari berita berdasarkan slug
        $berita = $this->models['berita']->findBySlug($slug);

        // Jika berita tidak ditemukan, lempar ke halaman 404
        if (!$berita) {
            throw PageNotFoundException::forPageNotFound("Berita dengan slug '{$slug}' tidak ditemukan.");
        }

        // Jika berita ditemukan, tampilkan view
        return $this->dynamicView('beritaDetail', [
            'berita' => $berita,
        ]);
    }

    public function hubungi_kami(){
        return $this->beranda(); // Shares similar logic as 'beranda'
    }

    public function reformasi(){
        return $this->beranda(); // Shares similar logic as 'beranda'
    }

    public function page($id)
{
    // Cari halaman berdasarkan ID atau slug
    $page = $this->models['pages']->findBySlug($id);

    // Jika halaman tidak ditemukan, lempar ke halaman 404
    if (!$page) {
        throw PageNotFoundException::forPageNotFound("Halaman dengan ID '{$id}' tidak ditemukan.");
    }

    // Jika halaman ditemukan, tampilkan view
    return $this->dynamicView('page', [
        'page' => $page,
    ]);
}

    public function login(){
        return view('login');
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('/');
    }

    public function validation_test(){
        return view('validationtest');
    }

    private function getNavbar() {
        $query = $this->db->query("SHOW COLUMNS FROM dt_grup_menu WHERE Field = 'navbar'");
        $row = $query->getRow();

        if ($row && isset($row->Type)) {
            preg_match("/^enum\((.*)\)$/", $row->Type, $matches);
            if (isset($matches[1])) {
                return str_getcsv($matches[1], ',', "'");
            }
        }
        return [];
    }

    private function getCountVisitor() {
        $this->db->query("SET sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $builder = $this->db->table('dt_visit');
        
        return [
            'today' => $this->countVisitors($builder, 'DATE(visited_at) = CURDATE()'),
            'yesterday' => $this->countVisitors($builder, 'DATE(visited_at) = CURDATE() - INTERVAL 1 DAY'),
            'this_week' => $this->countVisitors($builder, 'YEARWEEK(visited_at, 1) = YEARWEEK(CURDATE(), 1)'),
            'this_month' => $this->countVisitors($builder, 'MONTH(visited_at) = MONTH(CURDATE()) AND YEAR(visited_at) = YEAR(CURDATE())'),
            'total' => $this->countVisitors($builder),
            'active_users' => $this->countVisitors($builder, 'visited_at >= NOW() - INTERVAL 30 MINUTE'),
        ];
    }

    private function countVisitors($builder, $condition = null) {
        if ($condition) {
            $builder->where($condition);
        }
        return $builder->groupBy('ip_address, user_agent')->countAllResults();
    }

    public function displayLogo($filename)
{
    // Lokasi folder tempat file disimpan
    $filePath = WRITEPATH . 'uploads/' . $filename;

    // Cek apakah file ada
    if (!is_file($filePath)) {
        return $this->response->setStatusCode(404)->setBody('File not found.');
    }

    // Cek apakah ekstensi Fileinfo tersedia
    if (!extension_loaded('fileinfo')) {
        return $this->response->setStatusCode(500)->setBody('Fileinfo extension is not enabled.');
    }

    // Dapatkan tipe MIME file menggunakan finfo_file
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // Mendapatkan tipe MIME
    $mimeType = finfo_file($finfo, $filePath);
    finfo_close($finfo); // Menutup resource finfo

    // Tampilkan file dengan MIME yang sesuai
    return $this->response
        ->setHeader('Content-Type', $mimeType)
        ->setBody(file_get_contents($filePath));
}

}