Hal-hal yang perlu diperhatikan :
1. Membuat controller
- dalam membuat controller setiap controller extends CI_Controller();
- pada fungsi construct controller harus mendefinisikan library auth
  dan memanggil fungsi logged_in() seperti pada contoh controller login.


2. Membuat view
- untuk membuat view file master yang dipanggil untuk admin adalah file
  yang berada pada folder layout/ad_adminsekolah.
- contoh pemanggilan dapat dilihat di dalam controller schooladmin
- $data['main'] adalah halaman detail yang ingin di sisipkan di file master.


3.Untuk masuk ke halaman admin ketik link 'develop.studentbook.co/admin/'
  masukan username
  dan password sesuai dengan data di tabel users yang ada di 
  database studoid1

4. Untuk masuk ke halaman user ketik 'develop.studentbook.co/home/

5. Untuk controller admin semua di masukan dalam folder controller/admin/

6. Untuk view yang dijadikan layout masukan ke view/layout/

7. Untuk view sosial di masukan ke folder view/sosial/

8. untuk view akademik di masukan ke folder view/schooladmin/

9. Jika ingin merubah, menambahkan file css,js di folder asset, sebaiknya jangan di upload langsung karna akan 
   mereplace, jadi lebih baik di ubah melalui cpanel atau hosting langsung.


