// AJAX -> Merequest ke sumber dan dikembalikan dengan metode asyncronus atau meload halaman bagian tertentu tidak semuanya

// MENGGUNAKAN AJAX VERSI JAVASCRIPT FANILLA

// let keyword = document.getElementById('keyword');
// let liveSearch = document.getElementById('live-search');

// keyword.addEventListener('keyup', function(){
	
// 	// buat object ajax
// 	let ajax = new XMLHttpRequest();

// 	// persiapkan ajax nya || mengecek kesiapan sumber yang akan merespon
// 	ajax.onreadystatechange = function () {
// 		if( ajax.readyState == 4 && ajax.status == 200 ) {
// 			// response request dikelola disini
// 			liveSearch.innerHTML = ajax.responseText;
// 		}
// 	}

// 	// request ke sember :
// 	ajax.open('GET', 'layouts/live-search-produk.php?keyword=' + keyword.value, true);
// 	// jalankan request
// 	ajax.send();
// });

// MENGGUNAKAN AJAX VERSI jQuery
$('#keyword').on('keyup', function() {

	// load hanya bisa menggunakan mentode GET
	// cari wadah live-search dan load(ubah semua data dengan sumber yang direquest dan diresponse)
	// $('#live-search').load('layouts/live-search-produk.php?keyword=' + $('#keyword').val());

	// munculkan loader seolah olah system lagi mikir
	$('.loader').show();

	// ambil sumber data dan lakukan sesuatu sambil simpan hasil request data ke parameter function anonymous
	$.get('layouts/live-search-produk.php?keyword=' + $('#keyword').val(), function(hasil) {

		// cari wadah yang mempunya id live-search dan isikan / ganti html yang ada dengan hasil dari request ajax
		$('#live-search').html(hasil);
		// hilangkan animasi loader
		$('.loader').hide();
	});

});

