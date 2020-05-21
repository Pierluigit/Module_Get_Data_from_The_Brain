<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.4.1.slim.min.js"></script>
<script src="js/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/php_file_tree_jquery.js" type="text/javascript"></script>
<!-- dropzone -->
<script src="js/dropzone.js"></script>
<!-- fonctions ajax et de control -->
<script src="js/fonctions.js"></script>
<!-- font awesome pour les icones de ok validation -->
<script src="js/39f2876224.js" crossorigin="anonymous"></script>
<!-- data table -->
<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
<!-- configuration des tables -->
<script>
	$(document).ready( function () {
		$('#table_displayImport').DataTable( {
			"aaSorting": [7,'asc'],// debut à 0
			"pageLength": 100,
			"aoColumns": [
			{ "bVisible": true, "bSortable": false, "sWidth": "90px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "60px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "60px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "20px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "280px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "44px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "18px", "bSearchable": true },
			{ "bVisible": false, "bSortable": false, "sWidth": "80px", "bSearchable": true },
			{ "bVisible": true, "bSortable": false, "sWidth": "18px", "bSearchable": true }
			],
		} );
	} );
	$(document).ready( function () {
		$('#table_alphaThoughts').DataTable( {
			"aaSorting": [9,'asc'],// debut à 0
			"pageLength": 100,
			"aoColumns": [
			{ "bVisible": true, "bSortable": false, "sWidth": "120px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "60px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "60px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "60px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "20px", "bSearchable": false },
			{ "bVisible": true, "bSortable": true, "sWidth": "60px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "44px", "bSearchable": true },
			{ "bVisible": true, "bSortable": true, "sWidth": "222px", "bSearchable": true },
			{ "bVisible": true, "bSortable": false, "sWidth": "60px", "bSearchable": true },
			{ "bVisible": false, "bSortable": false, "sWidth": "20px", "bSearchable": true }
			],
		} );
	} );
</script>