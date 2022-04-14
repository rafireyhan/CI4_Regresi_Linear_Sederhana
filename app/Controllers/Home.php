<?php

namespace App\Controllers;

use App\Models\inputModel;
use App\Models\fileSystemModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends BaseController
{
    protected $inputModel;

    public function __construct()
    {
        $this->inputModel = new inputModel();
        $this->fileSystemModel = new fileSystemModel();
        $this->spreadsheet = new Spreadsheet();
        $this->writer = new Xlsx($this->spreadsheet);
        $this->reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $this->reader->setReadDataOnly(true);
    }

    public function index()
    {
        $data = [
            'title' => 'IFA-406 | 152018108'
        ];

        return view('index', $data);
    }

    public function input()
    {
        session();
        $input = $this->inputModel->findAll();

        $data = [
            'title' => 'IFA-406 | 152018108',
            'input' => $input,
            'validation' => \Config\Services::validation()
        ];

        return view('input_manual',$data);
    }

    public function tambah_data()
    {
        //validasi input
        if(!$this->validate([
            'nilaiX' => [
                'rules' => 'numeric',
                'errors' => [
                    'numeric' => 'Nilai X hanya boleh angka!'
                ]
            ],
            'nilaiY' => [
                'rules' => 'numeric',
                'errors' => [
                    'numeric' => 'Nilai Y hanya boleh angka!'
                ]
            ]
        ])){
            $validation = \Config\Services::validation();
            return redirect()->to('/Home/input')->withInput()->with('validation', $validation);
        };

        //masukan ke database
        $this->inputModel->save([
            'nilaiX' => $this->request->getVar('nilaiX'),
            'nilaiY' => $this->request->getVar('nilaiY')
        ]);

        session()->setFlashData('pesan', 'Data Berhasil Ditambahkan!');

        return redirect()->to('/Home/input');
    }

    public function input_hasil()
    {        
        $input = $this->inputModel->findAll();
        //Perhitungan Data
        $jumlahX = $this->inputModel->totalX();
        $jumlahY = $this->inputModel->totalY();
        $kuadratX = $this->inputModel->XKuadrat();
        $kuadratY = $this->inputModel->YKuadrat();
        $XdikaliY = $this->inputModel->XtimesY();
        $n = $this->inputModel->total_panen();
        $jumlahX2 = $this->inputModel->totalX_kuadrat();

        //Nilai A
        $paket1A = $jumlahY[0]->totalY * $kuadratX[0]->xKuadrat;
        $paket2A = $jumlahX[0]->totalX * $XdikaliY[0]->xKaliy;
        $paket3A = $n[0]->n * $kuadratX[0]->xKuadrat;
        $paket4A = $jumlahX2[0]->totalX_kuadrat;
        $paket1minus2 = $paket1A-$paket2A;
        $paket3minus4 = $paket3A-$paket4A;
        $nilaiA = round($paket1minus2/$paket3minus4,3);

        //Nilai B
        $paket1B = $n[0]->n  * $XdikaliY[0]->xKaliy;
        $paket2B = $jumlahX[0]->totalX * $XdikaliY[0]->xKaliy;
        $paket3B = $n[0]->n * $jumlahX[0]->totalX;
        $paket4B = $jumlahX2[0]->totalX_kuadrat;
        $paket1minus2B = $paket1B-$paket2B;
        $paket3minus4B = $paket3B-$paket4B;
        $nilaiB = round($paket1minus2B/$paket3minus4B,3);
        
        //dummy data
        $nilaiY = 0;
        //dd($nilaiB);

        $data = [
            'title' => 'IFA-406 | 152018108',
            'nilaiA' => $nilaiA,
            'nilaiB' => $nilaiB,
            'nilaiY' => $nilaiY,
            'input' => $input
        ];

        return view('input_manual_hasil', $data);
    }

    public function hasil_final()
    {
        $input = $this->inputModel->findAll();

        //FORECASTING
        $nX = $this->request->getVar('nX');
        $nilaiA = $this->request->getVar('nA');
        $nilaiB = $this->request->getVar('nB');
        $nilaiY = $nilaiA + $nilaiB*$nX;

        //Perhitungan Data
        $jumlahX = $this->inputModel->totalX();
        $jumlahY = $this->inputModel->totalY();
        $kuadratX = $this->inputModel->XKuadrat();
        $kuadratY = $this->inputModel->YKuadrat();
        $XdikaliY = $this->inputModel->XtimesY();
        $n = $this->inputModel->total_panen();
        $jumlahX2 = $this->inputModel->totalX_kuadrat();
        $jumlahY2 = $this->inputModel->totalY_kuadrat();

        //Perhitungan Nilai R
        $paket1 = $n[0]->n * $XdikaliY[0]->xKaliy;
        $paket2 = $jumlahX[0]->totalX * $jumlahY[0]->totalY;
        $paket3_kiri = $n[0]->n * $kuadratX[0]->xKuadrat;
        $paket3_kanan = $jumlahX2[0]->totalX_kuadrat;
        $paket3 = $paket3_kiri - $paket3_kanan;
        $paket4_kiri = $n[0]->n * $kuadratY[0]->yKuadrat;
        $paket4_kanan = $jumlahY2[0]->totalY_kuadrat;
        $paket4 = $paket4_kiri * $paket4_kanan;
        $atas = $paket1=$paket2;
        $bawah =sqrt($paket3*$paket4);
        $nilaiR = round($atas/$bawah,3);
        $nilaiKD = round(($nilaiR*$nilaiR)*100,3);

        //dd($nilaiR,$nilaiKD);

        $data = [
            'title' => 'IFA-406 | 152018108',
            'nilaiA' => $nilaiA,
            'nilaiB' => $nilaiB,
            'nilaiY' => $nilaiY,
            'nilaiR' => $nilaiR,
            'nilaiKD' => $nilaiKD,
            'input' => $input
        ];
        //dd($nilaiY);
        return view('input_manual_hasil', $data);
    }

    public function menu_excel()
    {
        session();
        $input = $this->inputModel->findAll();

        $data = [
            'title' => 'IFA-406 | 152018108',
            'input' => $input,
            'validation' => \Config\Services::validation()
        ];

        return view('input_excel', $data);
    }

    public function input_excel()
    {
        //Mengambil File
        $date = date('d/m/Y G:i:s');
        $upd = [
            'value' => $date
        ];
        $this->fileSystemModel->update(1, $upd);

        $file = $this->request->getfile('data_padi');

        if ($file != "") {
            unlink('exp/data_padi.xlsx');
            $ext = $file->getClientExtension();
            $data_fn = "data_padi." . $ext;
            $file->move("exp/", $data_fn);
        }
        //END Mengambil File

        //Membaca File
        $this->reader->setLoadSheetsOnly(["Sheet1"]);
        $workSheet = $this->reader->load("exp/data_padi.xlsx");

        $dataExcel = $workSheet->getActiveSheet()->toArray();
        //dd($dataExcel);

        foreach ($dataExcel as $d => $data){
            if ($d == 0){
               continue;
            }

            $x = $data[1];
            $y = $data[2];

            $this->inputModel->save([
                'nilaiX' => $x,
                'nilaiY' => $y
            ]);
        }

        session()->setFlashData('pesan', 'Data Berhasil Ditambahkan!');
        return redirect()->to('/Home/menu_excel');
    }
}