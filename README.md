VLMS: Validation Logic Management System - Pangkalan Data Pendidikan Tinggi 

PDDIKTI (Pangkalan Data Pendidikan Tinggi) menurut Undang-undang No. 12 tahun 2012 merupakan kumpulan data penyelenggaraan Pendidikan Tinggi seluruh Perguruan Tinggi yang terintegrasi secara nasional. Saat ini PDDIKTI dikembangkan dan dikelola oleh Direktorat Pendidikan Tinggi (DIKTI) dan menjadi kewajiban bagi Perguruan Tinggi (PT) untuk melaporankan kegiatan akademiknya kepada DIKTI, pelaporan PDDIKTI sejak tahun 2002 dilakukan menggunakan media elektronik yang dikirimkan kepusat/DIKTI dan ke Koordinator Perguruan Tinggi Swasta (Kopertis).
Pada tahun 2014, dengan pemanfaatan teknologi terkini DIKTI memperkenalkan cara pelaporan baru yang diharapkan lebih cepat  atau near realtime, memangkas jalur birokrasi yang panjang, dan manfaat lainnya. System pelaporan baru ini mengintegrasikan PT dengan DIKTI dengan metode komunikasi dua arah. Kurang lebih empat ribu PT yang akan menggunakan system tersebut dan tentunya transaksi datanya sendiri akan menjadi massif. Bagi DIKTI yang menjadi perhatian tidak hanya bagaimana integrasi yang dilakukan tetapi juga berfokus kepada kualitas data yang digunakan, baik itu dari dimensi completeness, timelessness, consistency, accuracy, integrity, dll. DIKTI bersama dengan Kopertis juga berperan sebagai lembaga yang mengawasi dan menjamin kualitas data yang dilaporankan oleh Perguruan Tinggi. Mengingat hal tersebut maka DIKTI memerlukan sebuah tool validator untuk dapat melakukan fungsi pengawasan tersebut dan dapat melakukan analisis dan menemukan kemungkinan-kemungkinan manipulasi/kecurangan yang dilakukan oleh Perguruan Tinggi. Modus dan motif kecurangan tentunya akan terus berkembang sejalan dengan kebijakan DIKTI, tentunya logic validasi juga akan mengikuti modus tersebut.
Validator PDDIKTI merupakan sebuah framework yang didalamnya terdapat Development Kit, Scheduler, dan fitur lain yang diperlukan untuk membangun logic validasi. Pengguna Validator PDDIKTI dibagi menjadi admin Kopertis/DIKTI/BanPT dan Kontributor. Kontributor merupakan kumpulan orang-orang kopertis/DIKTI yang diberikan kewenangan untuk mengembangkan logic validator karena dianggap yang mengetahui praktek-praktek manipulasi yang sering terjadi. Dalam hal ini Validator PDDIKTI diharapkan dapat memberikan interface untuk contributor membuat modul validasi yang tentunya dengan aturan-aturan teknis yang distandarkan oleh validator PDDIKTI –mirip seperti pengembangan suatu system berbasis komunitas, dimana ada contributor yang mengembangkan plug-in/modul yang digunakan pada system tersebut--. Logic validasi yang dibuat satu kontributor sifatnya open dan bisa dikritisi oleh contributor lain agar logic validasinya bisa matang dan bugs preventif. Setiap proses validasi tujuannya adalah memberikan status validitas suatu kumpulan data yang nantinya akan menjadi catatan/evidence untuk data itu sendiri.
Pengguna non-kontributor bisa melihat report hasil logic validasi yang dikembangkan contributor dan memberikan status final terhadap data tersebut masuk dalam kategori fraud, perlu perbaikan, atau lainnya. Proses pemberian status final ini bisa langsung oleh system atau perlu persetujuan dari pengguna non-kontributor sesuai dengan setup modul validasi.
Kemudian fitur lain yang diharapkan dalam Validator PDDIKTI adalah adanya modul untuk mendeteksi redundancy entitas mahasiswa dan dosen untuk kemudian dapat dilakukan proses merging data –menjadikan data kedalam satu GUID--. Semua data yang memiliki sudah divalidasi akan dialirkan kembali ke Perguruan Tinggi melalui Feeder. 




