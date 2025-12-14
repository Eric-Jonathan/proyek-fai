<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client; // Pastikan ini diimpor
use Google_Service_Drive; // Pastikan ini diimpor
use Illuminate\Support\Facades\Log; // Digunakan untuk debugging

class GoogleDriveAuthController extends Controller
{
    /**
     * Menginisialisasi Klien Google dengan kredensial OAuth 2.0.
     */
    private function getClient()
    {
        $client = new Google_Client();
        
        // Menggunakan kredensial dari .env
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        
        // Mengatur Redirect URI yang sudah dimasukkan di Google Console
        $redirectUri = url(env('GOOGLE_REDIRECT_URI')); 
        $client->setRedirectUri($redirectUri);
        
        // Menentukan Scope (izin) yang diminta dari pengguna
        $client->addScope(Google_Service_Drive::DRIVE); // Atau DRIVE_FILE
        
        // WAJIB: Meminta Refresh Token. Tanpa ini, token hanya berlaku 1 jam.
        $client->setAccessType('offline'); 
        
        // WAJIB: Memaksa Google untuk menampilkan layar persetujuan
        $client->setPrompt('select_account consent'); 

        return $client;
    }
    
    /**
     * Langkah 1: Mengarahkan pengguna ke Google untuk otorisasi.
     */
    public function handleAuth()
    {
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        
        // Arahkan browser ke halaman login/otorisasi Google
        return redirect($authUrl); 
    }
    
    /**
     * Langkah 2: Menangani callback dari Google dan mendapatkan Refresh Token.
     */
    public function handleCallback(Request $request)
    {
        if ($request->has('error')) {
            return "Error Otorisasi: " . $request->get('error');
        }

        $client = $this->getClient();
        $authCode = $request->get('code');
        
        // Tukar kode otorisasi dengan token akses/refresh
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Ambil Refresh Token. 
        $refreshToken = $accessToken['refresh_token'] ?? null;
        
        if ($refreshToken) {
            // --- Penyimpanan Refresh Token ke file .env ---
            $path = base_path('.env');
            if (file_exists($path)) {
                file_put_contents($path, str_replace(
                    'GOOGLE_REFRESH_TOKEN=' . env('GOOGLE_REFRESH_TOKEN'),
                    'GOOGLE_REFRESH_TOKEN=' . $refreshToken,
                    file_get_contents($path)
                ));
            }
            // --- Akhir Penyimpanan ---
            
            // Beri tahu pengguna bahwa proses berhasil
            return "<h3>SUCCESS!</h3><p>Refresh Token berhasil didapatkan dan disimpan di file **.env**.</p>" . 
                   "<p><strong>NILAI TOKEN:</strong> <code>" . $refreshToken . "</code></p>" .
                   "<p><strong>LANGKAH SELANJUTNYA:</strong></p>" .
                   "<ol><li>Hapus rute sementara <code>/google/auth</code> dan <code>/google/oauth</code> dari <code>routes/web.php</code>.</li><li>Lanjutkan dengan Refaktor fungsi upload di controller Anda.</ol>";
                   
        } else {
            return "<h3>FAILED!</h3><p>Gagal mendapatkan Refresh Token.</p><p>Pastikan Anda sudah mengatur <code>setAccessType('offline')</code> dan <code>setPrompt('consent')</code> di Google_Client.</p>";
        }
    }
}