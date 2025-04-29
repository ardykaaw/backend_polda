import unittest

def validasi_nilai(nilai):
    if nilai >= 75:
        return "Lulus"
    else:
        return "Gagal"

class TestValidasiNilai(unittest.TestCase):
    def test_nilai_diatas_batas(self):
        self.assertEqual(validasi_nilai(80), "Lulus")
        self.assertEqual(validasi_nilai(90), "Lulus")
        self.assertEqual(validasi_nilai(100), "Lulus")
    
    def test_nilai_batas(self):
        self.assertEqual(validasi_nilai(75), "Lulus")
    
    def test_nilai_dibawah_batas(self):
        self.assertEqual(validasi_nilai(74), "Gagal")
        self.assertEqual(validasi_nilai(60), "Gagal")
        self.assertEqual(validasi_nilai(0), "Gagal")
    
    def test_nilai_invalid(self):
        with self.assertRaises(TypeError):
            validasi_nilai("abc")
        with self.assertRaises(TypeError):
            validasi_nilai(None)

if __name__ == '__main__':
    # Input nilai dari user
    try:
        nilai = float(input("Masukkan nilai (0-100): "))
        if nilai < 0 or nilai > 100:
            print("Nilai harus antara 0-100")
        else:
            hasil = validasi_nilai(nilai)
            print(f"Hasil: {hasil}")
    except ValueError:
        print("Input harus berupa angka")
    
    # Jalankan unit test
    unittest.main()
