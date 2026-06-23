<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InputMultipleController extends BaseController
{
    public function index()
    {
        return view('admin.input-multiple.index', [
            'title' => 'Input Multiple Data'
        ]);
    }

    public function store(Request $request)
    {
        // Hapus batas waktu maksimal eksekusi agar proses CURL berulang tidak terkena Time Out (30s)
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {

            $spreadsheet = IOFactory::load(
                $request->file('file')->getRealPath()
            );

            $payload = [];

            foreach ($spreadsheet->getWorksheetIterator() as $sheet) {

                $sheetName = trim($sheet->getTitle());

                $rows = $sheet->toArray(
                    null,
                    true,
                    true,
                    false
                );

                if (count($rows) <= 1) {
                    continue;
                }

                // hapus header
                array_shift($rows);

                $sheetData = [];

                foreach ($rows as $row) {

                    /**
                     * Skip jika seluruh kolom kosong
                     */
                    $isEmptyRow = true;

                    foreach ($row as $cell) {

                        if (
                            $cell !== null &&
                            trim((string)$cell) !== ''
                        ) {
                            $isEmptyRow = false;
                            break;
                        }
                    }

                    if ($isEmptyRow) {
                        continue;
                    }

                    switch ($sheetName) {

                        /**
                         * ======================================
                         * ANGKATAN
                         * angkatan
                         * ======================================
                         */
                        case 'Angkatan':

                            if (
                                empty(trim($row[0] ?? ''))
                            ) {
                                continue 2;
                            }

                            $sheetData[] = [
                                'angkatan' => trim($row[0]),
                            ];

                            break;

                        /**
                         * ======================================
                         * PRODI
                         * nama_prodi
                         * ======================================
                         */
                        case 'Prodi':

                            if (
                                empty(trim($row[0] ?? ''))
                            ) {
                                continue 2;
                            }

                            $sheetData[] = [
                                'nama_prodi' => trim($row[0]),
                            ];

                            break;

                        /**
                         * ======================================
                         * DOSEN
                         * nama_dosen
                         * ======================================
                         */
                        case 'Dosen':

                            if (
                                empty(trim($row[0] ?? ''))
                            ) {
                                continue 2;
                            }

                            $sheetData[] = [
                                'nama_dosen' => trim($row[0]),
                            ];

                            break;

                        /**
                         * ======================================
                         * MAHASISWA
                         * nim
                         * nama_mahasiswa
                         * no_telfon
                         * ======================================
                         */
                        case 'Mahasiswa':

                            if (
                                empty(trim($row[0] ?? ''))
                            ) {
                                continue 2;
                            }

                            $noTlp = trim($row[2] ?? '');
                            if (strtolower($noTlp) === 'none') {
                                $noTlp = null;
                            }

                            $sheetData[] = [
                                'username'  => trim($row[0]), // nim -> username
                                'name'      => trim($row[1] ?? 'Mahasiswa ' . trim($row[0])), // if empty name, use default
                                'no_telfon' => $noTlp,
                                'password'  => trim($row[0]), // default password is nim
                                'type'      => 0 // 0 = Mahasiswa
                            ];

                            break;

                        /**
                         * ======================================
                         * ALAT
                         * nama_alat
                         * stok
                         * status_alat
                         * ======================================
                         */
                        case 'Alat':

                            if (
                                empty(trim($row[0] ?? ''))
                            ) {
                                continue 2;
                            }

                            $sheetData[] = [
                                'nama_barang'   => trim($row[0]),
                                'stok'          => (int) trim($row[1] ?? 0),
                                'status_barang' => (int) trim($row[2] ?? 0),
                            ];

                            break;

                        /**
                         * ======================================
                         * RUANG
                         * nama_ruang
                         * keterangan
                         * status_ruang
                         * ======================================
                         */
                        case 'Ruang':

                            if (
                                empty(trim($row[0] ?? '')) ||
                                empty(trim($row[1] ?? '')) ||
                                trim($row[2] ?? '') === ''
                            ) {
                                continue 2;
                            }

                            // skip keterangan:
                            // status_ruang
                            // 0 = tidak tersedia
                            // 1 = tersedia
                            if (
                                !is_numeric(trim($row[2]))
                            ) {
                                continue 2;
                            }

                            $sheetData[] = [
                                'nama_ruang'   => trim($row[0]),
                                'keterangan'   => trim($row[1]),
                                'status_ruang' => (int) trim($row[2]),
                            ];

                            break;

                        /**
                         * ======================================
                         * JAM
                         * jam
                         * ======================================
                         */
                        case 'Jam':

                            if (
                                empty(trim($row[0] ?? ''))
                            ) {
                                continue 2;
                            }

                            $sheetData[] = [
                                'jam' => trim($row[0]),
                            ];

                            break;

                        /**
                         * ======================================
                         * JADWAL RUANGAN
                         * ======================================
                         */
                        case 'jadwal_ruangan':
                            if (
                                empty(trim($row[0] ?? '')) ||
                                empty(trim($row[1] ?? '')) ||
                                empty(trim($row[2] ?? '')) ||
                                empty(trim($row[3] ?? '')) ||
                                empty(trim($row[4] ?? '')) ||
                                empty(trim($row[5] ?? '')) ||
                                empty(trim($row[6] ?? '')) ||
                                empty(trim($row[7] ?? ''))
                            ) {
                                continue 2;
                            }

                            // Cari ID ruang berdasarkan nama_ruang
                            $namaRuang = trim($row[0]);
                            $ruang = \App\Models\Ruang::where('nama_ruang', $namaRuang)->first();
                            if (!$ruang) {
                                continue 2; // Jika ruang tidak ada di DB, skip
                            }

                            $sheetData[] = [
                                'ruang_id'       => $ruang->id,
                                'mata_kuliah'    => trim($row[1]),
                                'dosen'          => trim($row[2]),
                                'hari'           => ucfirst(strtolower(trim($row[3]))),
                                'jam_mulai_ke'   => (int) trim($row[4]),
                                'jam_selesai_ke' => (int) trim($row[5]),
                                'prodi'          => trim($row[6]),
                                'angkatan'       => trim($row[7]),
                                'kelas'          => trim($row[8] ?? ''), // optional
                                'status_ruang'   => 1, // otomatis 1 (tersedia)
                                'user_id'        => null,
                            ];

                            break;

                        default:
                            break;
                    }
                }

                if (!empty($sheetData)) {
                    $payload[$sheetName] = $sheetData;
                }
            }

            if (empty($payload)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data valid yang ditemukan di Excel'
                ], 400);
            }

            // ==========================================
            // PROSES UPLOAD KE BACKEND DATABASE
            // ==========================================
            $results = [];

            foreach ($payload as $tableName => $rowsData) {
                $endpoint = '';

                switch ($tableName) {
                    case 'Angkatan':
                        $endpoint = '/api/angkatan/post';
                        break;
                    case 'Prodi':
                        $endpoint = '/api/prodi/post';
                        break;
                    case 'Dosen':
                        $endpoint = '/api/dosen/post';
                        break;
                    case 'Mahasiswa':
                        $endpoint = '/api/mahasiswa/post';
                        break;
                    case 'Alat':
                        $endpoint = '/api/alat/post';
                        break;
                    case 'Ruang':
                        $endpoint = '/api/ruang/post';
                        break;
                    case 'Jam':
                        $endpoint = '/api/jam/post';
                        break;
                    case 'jadwal_ruangan':
                        $endpoint = '/api/jadwalruang/post';
                        break;
                }

                if ($endpoint) {
                    $successCount = 0;
                    $errorCount = 0;

                    foreach ($rowsData as $postData) {
                        $client = curl_init();
                        curl_setopt_array($client, [
                            CURLOPT_URL => $this->backendUrl . $endpoint,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => http_build_query($postData),
                            CURLOPT_SSL_VERIFYPEER => false,
                            CURLOPT_SSL_VERIFYHOST => false,
                        ]);

                        $response = curl_exec($client);
                        $httpCode = curl_getinfo($client, CURLINFO_HTTP_CODE);
                        curl_close($client);

                        if ($httpCode == 201 || $httpCode == 200) {
                            $successCount++;
                        } else {
                            $errorCount++;
                            // Log the error for debugging
                            \Log::error("Upload failed for {$tableName}. HTTP Code: {$httpCode}. Response: {$response}. Data: " . json_encode($postData));
                        }
                    }

                    $results[$tableName] = [
                        'success' => $successCount,
                        'failed' => $errorCount
                    ];
                }
            }

            return view('admin.input-multiple.results', [
                'title' => 'Hasil Upload',
                'results' => $results
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}