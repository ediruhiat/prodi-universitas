
// DataTable Extensions
jQuery(document).ready(function($) {
    jQuery('#tabelpage').DataTable();
} );

jQuery(document).click(function() {
	url = jQuery("#searchid").val();
    jQuery("#serp").attr("href", "admin.php?page=generate_scholar_id&gsid="+url);
} );

// Scholar ID Searc Modal
jQuery(function(){
	jQuery("#cek-sch").click(function(){
		jQuery("#cek-sch").attr("href", "https://"+jQuery("#dosen-profile").val());
	});
});
