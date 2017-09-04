<?php
namespace App;

use App\Config\Front;

class Template {
	
	//Redux Framework Varible
	public $redux;

	public function __construct() {

		$this->redux = & $GLOBALS[Front::REDUX];
	}


/*
 * Header Site (header.php)
 */
public function header(){
if(Front::COMPRESS_HTML ===false) {
    echo '<!DOCTYPE html>'."\n";
}
?>
<html lang="fa-IR" dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<?php if (is_search()) { ?><meta name="robots" content="noindex, nofollow" /> <?php } ?>
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php wp_head(); //echo "\n";?>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
		<?php
	}


	/*
	 * Footer Site (footer.php)
	 */
	public function footer(){
wp_footer();
echo '
</body>
</html>
';
	}















	
	public function show_time($text) { //Check Show Time in Site
		if (get_field('show-datetime') =="بله") { return $text;}
	}
	
	public function wp_strip_text($text) {
		return wp_strip_all_tags(strip_shortcodes($text));
	}
	
	public function product_price($text) {
		return per_number(number_format($text));
	}

//******************************************************************** Header site */
public function headersite() {
	
if (is_home()) { echo'<h1 class="site-title">'.$this->redux['h1-description'].'</h1>'; }

echo '
<!--header-->
<div class="container-fluid header">
<div class="container">
<div class="col-lg-2 col-md-2 logo wow fadeInRight"><a href="'.home_url().'" title="'.get_bloginfo('name').'"><img src="'.$this->redux['logo-right']['url'].'" alt="'.$this->redux['logo-description'].'"></a></div>
<div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-1 social-top">
<ul class="wow fadeInDown" data-wow-delay="1.2s">';
for ($x=1; $x<=4; $x++) {
	$ico = $this->redux['topicon'.$x];
	if ($ico !='') { echo '<li><a href="'.$this->redux['topiconlink'.$x].'" title="'.$this->redux['topseo'.$x].'" target="_blank"><i class="fa '.$ico.'"></i></a></li>'; }
}

echo '
</ul>
</div>
<div class="col-lg-2 col-md-2 tel hidden-sm hidden-xs wow fadeInUp" data-wow-delay="1.4s">
<i class="fa fa-phone"></i>
<span>'.per_number($this->redux['tel-co']).' </span>
</div>';
echo do_shortcode('[user-panel]');
echo '
</div>
	
	<div class="clearfix"></div>
	</div>

<div class="clearfix"></div>';

//search box
echo '
<!--Search box-->
<div class="container-fluid search-box-res hidden-lg hidden-md">
<div class="container">
<div class="search-top-bar text-center">
<form action="'.home_url().'" method="get" class="form-search">
<input type="text" class="input-search" name="s" placeholder="جستجو در سایت ..." autocomplete="off">
<button class="input-search-submit text-left"><i class="fa fa-search"></i></button>
</form> 
<div class="clearfix"></div>  
</div>
</div>
</div>';

echo '
<!--Navigation-->
<div class="container-fluid navigation-site">
		<nav class="navbar navbar-default">
		  <div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			<div class="show-menu hidden-lg hidden-md hidden-sm">منوی صفحات</div>
			</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
<div class="container menu-weight collapse navbar-collapse" id="bs-megadropdown-tabs">';


$nav_menu = wp_get_nav_menu_object($this->redux['main-menu-id']);
echo wp_nav_menu( array(
		'menu'              => $nav_menu->name,
		'depth'             => 0,
		'echo' => false,
		'container'         => '',
		'menu_class'        => 'nav navbar-nav rtl wow fadeInUp', //Navbar right class for bootstrap submenu
		'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		'walker'            => new wp_bootstrap_navwalker())
);

echo '
<!--Search Box-->
<div class="pull-left hidden-sm hidden-xs search-nav-bar">
<form action="'.home_url().'" method="get" class="form-search wow fadeInLeft">
<input type="text" class="input-search" name="s" placeholder="جستجو ..." autocomplete="off">
<button class="input-search-submit text-left"><i class="fa fa-search"></i></button>
</form> 
<div class="clearfix"></div>
</div>

<div class="clearfix"></div>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>

<div class="clearfix">
</div>
</div>';
	
}

//******************************************************************** modal Empty */
public function modal_empty() {
echo '
<!-- Modal Product -->
<div class="modal-owl" style="display:none;">
<div class="col-xs-6 text-right"><i class="fa fa-close" id="close-modal"></i></div>
<div class="clearfix"></div>
<div style="width:100%; height:5px; border-bottom:1px solid #f3f3f3;"></div>
<div id="modal-text"> ';
do_action('modal-text');
echo '
</div><!-- Modal text-->
</div>';
do_action('modal-js');
}



/***********************************Slideshow Khadamat*/
public function slideshow_khadamat(){
$export = '';
	
$perRow = 4;
$counter = 0;
$export .=''; //First
$q = 0; //animation

if (isset($this->redux['slideshow-khadamat']) && !empty($this->redux['slideshow-khadamat'])) {
	foreach((array)$this->redux['slideshow-khadamat'] as $slider ) {

	
if($counter % $perRow == 0 && $counter != 0) {
$q = 0;
$export .='
<div class="clearfix"></div>'."\n"; 
}
$counter++;
	
$imgurl =  $this->placeholdit(130,130);
if ($slider['image'] !=="") { 
$imgurl = wp_get_attachment_image_src( $slider['attachment_id'], 'thumb-150' ); 
$imgurl = $imgurl[0]; 
}

//$title
$title = 'عنوان تب';
if ($slider['title'] !=="") { $title = $slider['title']; }

/*Content*/
$field = $this->wp_strip_text($slider['description']);
$charactercontent = 154;
if (mb_strlen($field) >=$charactercontent) { $morecontent =" .."; } else { $morecontent=""; }

//$wow = array(1 => 'Up',2 => 'Down',3 => 'Right',4 => 'Left');
$wow = array(1 => 'Up',2 => 'Down');
$rand_keys = array_rand($wow, 1);
$rand_keys2 = array_rand($wow, 1);

$animation = 1 + ($q * 0.2);	
//<div class="col-md-3 col-sm-6 box-index-info wow fadeIn'.$wow[$rand_keys].'" data-wow-delay="'.$animation.'s">
$export .='
<div class="col-md-3 col-sm-6 box-index-info">
<div class="tab-index-img wow fadeIn'.$wow[$rand_keys].'"><img src="'.$imgurl.'" alt="'.$title.'"></div>
<h2><a href="'.$slider['url'].'" title="'.$title.'"'.($slider['title'] =="طراحی استراتژی محتوا و فروش" ? ' style="font-size: 18.5px;"' : '').'>'.$title.'</a></h2>
<p class="wow fadeIn'.$wow[$rand_keys2].'" data-wow-delay="1.2s">'.mb_substr($field, 0, $charactercontent).$morecontent.'</p>
</div>
';

$q++;
	}
}

$export .=''."\n"; //End first
///	

return $export;
}


/*****************************index_tab*/
public function count_multi_tab() {
	static $test = 0;
     $test++;
     return $test . PHP_EOL; 
}

public function index_list_tab() {	
$link ="";
$text ="";

for ($i=1; $i<=$this->redux['number-horizental-special-tab']; $i++) {

$id_tab = "horizental-list-tab-".$i;
$class_active_head = "";
$class_active = "";

if ($i ==1) { $class_active_head =' class="active"'; $class_active =' in active'; }

/***************************************Link*/
$link .='<li role="presentation"'.$class_active_head.'><a href="#'.$id_tab.'" aria-controls="'.$id_tab.'" role="tab" data-toggle="tab">'.$this->redux['vtab-title-'.$i].'</a></li>';

/***************************************Text*/
$text .='<div role="tabpanel" class="tab-pane fade'.$class_active.'" id="'.$id_tab.'">';
$text .=do_shortcode(trim($this->redux['vtab-text-'.$i], "</p>"));
$text .='</div>';

}//For loop end

echo  '
<!--index Tab-->
<div class="container index-tab">

<div class="col-xs-12 nopadding">
<div class="title-horizental-box no-padding-tab-title">
<ul class="nav nav-tabs horizental-tab wow fadeInUp" role="tablist" id="myTab">';
	
echo $link;

echo  '
</ul>
</div>
<div id="myTabContent" class="tab-content">';
	
echo $text;

echo '
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>';
}


/*************************************Ticker */
public function ticker(){
	
/* ticker */
$text ="";
$link ="";
$args = array (
	'meta_query' => array(array('key' => 'show-ticker','value' => 'بله')),
	'posts_per_page' => $this->redux['ticker-number-show'],
	'order'  => 'DESC',
	'orderby' => 'id'
);

// The Query
$query = new WP_Query( $args );
$count = $query->post_count;
$i = 1;
while ($query->have_posts()):
$query->the_post();
if ($i === $count) {
//Last Item
$text .='"'.get_the_title().'"';
$link .='"'.get_permalink($post->ID).'"';
} else {
$text .='"'.get_the_title().'",';
$link .='"'.get_permalink($post->ID).'",';
}
$i++;

endwhile;
wp_reset_postdata();	
	
echo '
<!--top news-->
<div class="container-fluid topnews hidden-sm hidden-xs">
<div class="container">
<div class="col-md-12">

<div class="ticker wow fadeInUp">
<span class="title-ticker wow fadeInRight" data-wow-delay="1s"><i class="fa fa-bell"> </i> '.$this->redux['title-ticker'].'</span>
<span id="theTicker" class="wow fadeInRight" data-wow-delay="1.2s">';

echo '
<script>
var theSummaries = new Array('.$text.');
var theSiteLinks = new Array('.$link.');
</script>
</span>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>';	
}



public function blog_index(){
	
//blog
echo '
<div class="container marg-top">
<div class="col-md-6 box-home">
<h2 class="head-title wow fadeInRight"><a href="'.get_category_link( $this->redux['blog-cat'] ).'" title="'.get_cat_name($this->redux['blog-cat']).'"><i class="fa fa-feed"></i> '.$this->redux['title-blog-site'].'</a><a href="'.get_category_link( $this->redux['blog-cat'] ).'" title="'.get_cat_name($this->redux['blog-cat']).'" class="show-archive"><i class="fa fa-search-plus"></i> آرشیو مطالب</a></h2>
<div class="sp-line wow fadeInRight"></div>

<ul class="list-blog">';

$args = array (
	'meta_query' => array(array('key' => 'show-blog','value' => 'بله')),
	'posts_per_page' => 6,
	'order'  => 'DESC',
	'orderby' => 'id'
);

// The Query
$query = new WP_Query( $args );
$count = $query->post_count;
$q=0;
while ($query->have_posts()):
$query->the_post();

/*Title*/
$character = $this->redux['ch-blog-title'];
if (mb_strlen(get_the_title()) >=$character) { $moref =" .."; } else { $moref=""; }


//Get Original Date
$postd = get_post( get_the_ID() ); 

$animation = 1 + ($q * 0.2);
echo '<li class="wow fadeInDown" data-wow-delay="'.$animation.'s"><i class="fa fa-list-alt"></i><a href="'.get_permalink($post->ID).'" title="'.get_the_title().'"> '.mb_substr(get_the_title(), 0, $character).$moref.'</a><time datetime="'.$postd->post_date.'">[ '.get_the_time('l j F Y', $post->ID).' ]</time></li>';

$q++;
endwhile;
wp_reset_postdata();


echo '
</ul>
</div>

<div class="col-md-6 box-home">
<h2 class="head-title"><a href="'.get_category_link( $this->redux['shop-cat'] ).'" title="'.get_cat_name($this->redux['shop-cat']).'"><i class="fa fa-shopping-cart"></i> '.$this->redux['title-shop-site'].'</a></h2>
<div class="sp-line pad-35"></div>

<div class="control-baseket wow fadeInLeft">
    <a href="#carousel-example-basket" role="button" data-slide="next" title="محصول بعدی">
    <i class="fa fa-chevron-right" aria-hidden="true"></i>
  </a>
  <a href="#carousel-example-basket" role="button" data-slide="prev" title="محصول قبلی">
    <i class="fa fa-chevron-left"></i>
  </a>
</div>
<div class="clearfix"></div>
<div class="basket-slideshow">
<div id="carousel-example-basket" class="carousel slide" data-ride="carousel">
<!-- Wrapper for slides -->
<div class="carousel-inner" role="listbox">';
  
 
$args = array (
	'meta_query' => array(array('key' => 'show-shop','value' => 'بله')),
	'posts_per_page' => $this->redux['number-shop-show'],
	'order'  => 'DESC',
	'orderby' => 'id'
); 
// The Query
$query = new WP_Query( $args );
$count = $query->post_count;
$r=1;
while ($query->have_posts()):
$query->the_post();

if($r ==1) {
echo '<div class="item active">';	
} else {
	echo '<div class="item">';
}
$r++;

$img = $this->placeholdit(150,150);
if ( has_post_thumbnail() ) {
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumb-150');
$img = $thumb[0];
}

/*Title*/
$character = $this->redux['ch-sho-title'];
if (mb_strlen(get_the_title()) >=$character) { $moref =" .."; } else { $moref=""; }

/*Content*/
$field = $this->wp_strip_text(get_the_content());
$charactercontent = 105;
if (mb_strlen($field) >=$charactercontent) { $morecontent =" .."; } else { $morecontent=""; }

echo '
	<div class="item-basket-index">						
	<div class="pull-right wow fadeInRight" data-wow-delay="1.2s"><img src="'.$img.'" alt="'.get_the_title().'"></div>
	<a href="'.get_permalink($post->ID).'" title="'.get_the_title().'" class="wow fadeInUp" data-wow-delay="1s">'.mb_substr(get_the_title(), 0, $character).$moref.'</a>';
	
	if(is_post_product($post->ID) ===true) {
		echo '<span class="wow fadeInDown" data-wow-delay="1s">قیمت پستی محصول : '.$this->product_price(get_field('post-price')).' تومان</span>';
	} else {
	$it = show_item_price_dl_product($post->ID);
	echo '<span class="wow fadeInDown" data-wow-delay="1s" dir="rtl">قیمت '.$it['name'].' : '.$this->product_price($it['price']).' تومان</span>';
	}
	
	echo '
	<p class="wow fadeInRight" data-wow-delay="1s">'.mb_substr($field, 0, $charactercontent).$morecontent.'</p>
	<div class="add-to-cart pull-left"><a href="#" data-basket="'.get_the_ID().'" title="افزودن به سبد خرید"><i class="fa fa-shopping-cart"></i> '.$this->redux['add-to-c'].'</a></div>
	<div class="clearfix"></div>	
</div>
';

echo '</div>';

endwhile;
wp_reset_postdata(); 
	 
echo '	 
</div>
  </div>

</div>

</div>
</div>
<div class="clearfix"></div>
';
}


//********************************************************************فوتر سایت */
public function footer_site() {
	

echo '
<!--footer-->
<div class="container-fluid footer">
<div class="container">
<div class="col-lg-7 col-md-5 rtl">
<p class="wow fadeInRight">'.$this->redux['footer-copyright'].'<br>
<i class="fa fa-code"></i> طراحی و پشتیبانی : <a href="http://irwebdesign.ir/" title="طراحی وب سایت" target="_blank">میزبان سیستم خزر</a></p>

</div>
<div class="col-lg-5 col-md-7 text-center">
<div class="footer-li hidden-xs wow fadeInUp">
';

$menu_id = $this->redux['menu-footer-site-select'];
$nav_menu = wp_get_nav_menu_object($menu_id);
echo wp_nav_menu( array(
                'menu'              => $nav_menu->name,
                'depth'             => 1,
				'echo' => false,
                'container'         => '',
                'menu_class'        => '',
				'walker'=> new MFC_Walker_Nav_Menu()
				)
);

echo '
</div>
<div class="social-link-footer ltr text-center">';

if ($this->redux['rss-link'] !=="") { echo  '<a href="'.$this->redux['rss-link'].'" title="Rss"><i class="fa fa-rss"></i></a>'; }
if ($this->redux['googleplus-link'] !=="") { echo  '<a href="'.$this->redux['googleplus-link'].'" target="_blank" title="Google plus"><i class="fa fa-google-plus"></i></a>'; }
if ($this->redux['facebook-link'] !=="") { echo  '<a href="'.$this->redux['facebook-link'].'" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>'; }
if ($this->redux['twitter-link'] !=="") { echo  '<a href="'.$this->redux['twitter-link'].'" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>'; }
if ($this->redux['instagram-link'] !=="") { echo  '<a href="'.$this->redux['instagram-link'].'" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a>'; }
if ($this->redux['telegram-link'] !=="") { echo  '<a href="'.$this->redux['telegram-link'].'" target="_blank" title="Telegram"><i class="fa fa-paper-plane"></i></a>'; }

echo '
</div>
</div>
</div>
</div>';

}



public function padcast_index(){
	
echo '
<!--padkast-->
<div class="container padkast-index">
<div class="col-xs-12 padkast-div">
<div class="col-md-1 right-sefr wow fadeInRight">
<div class="icon-phone-responsive hidden-lg hidden-md visible-sm visible-xs"><i class="fa fa-microphone"></i><a href="'.get_category_link( $this->redux['padcast-cat'] ).'" title="'.get_cat_name($this->redux['padcast-cat']).'"> '.$this->redux['title-padcast-site'].' </a></div>
<div class="icon-phon hidden-sm hidden-xs"><a href="'.get_category_link( $this->redux['padcast-cat'] ).'" title="'.get_cat_name($this->redux['padcast-cat']).'"><i class="fa fa-microphone"></i></a></div></div>
<div class="col-md-10">

<div id="carousel-example-generic" class="carousel slide wow fadeInUp" data-ride="carousel">

<!-- Wrapper for slides -->
<div class="carousel-inner" role="listbox">';
  
  
$args = array (
	'cat' => $this->redux['padcast-cat'],
	'posts_per_page' => $this->redux['number-padcast-show'],
	'order'  => 'DESC',
	'orderby' => 'id'
);

// The Query
$x = 1;
$query = new WP_Query( $args );
while ($query->have_posts()):
$query->the_post();


if($x ==1) {
echo '<div class="item active">';	
} else {
	echo '<div class="item">';
}
$x++;


echo '
<div class="item-padkast-index">
<a href="'.get_permalink($post->ID).'" title="'.get_the_title().'"><i class="fa fa-bullhorn"></i> '.get_the_title().' </a>
<span>[ '.per_number(get_field('time-audio-blog')).' دقیقه ]</span>
'.(get_field('vip') == 'بله' ? '<span class="vip">[ اعضای ویژه سایت ]</span>' : '').' 
	 </div>
    </div>
';

endwhile;
wp_reset_postdata();

echo '
</div>
</div>

</div>
<div class="col-md-1 psdkast-button text-center wow fadeInDown" data-wow-delay="1s">

  <!-- Controls -->
    <a class="right-pad" href="#carousel-example-generic" role="button" data-slide="next" title="پادکست بعدی">
    <i class="fa fa-chevron-right" aria-hidden="true"></i>
  </a>
  <a class="left-pad" href="#carousel-example-generic" role="button" data-slide="prev" title="پادکست قبلی">
    <i class="fa fa-chevron-left"></i>
  </a>

</div>
</div>
</div>
<div class="clearfix"></div>';
}


//********************************************************************شرکت های فعال */
public function hamian_component() {

$export = '
<!--our car-->
<div class="container-fluid our-work">
<div class="container">
<div class="head-title-car text-center wow fadeInUp">'.$this->redux['title-hamian-site'].'</div>
<div class="sp-line seprate-customer wow fadeInUp" data-wow-delay="1.2s" style="margin:5px auto;"></div>


<div class="col-md-12">
	<div class="row">
	
		<!--show in mobile-->
		<div class="mobile-logo-company visible-sm visible-xs hidden-lg hidden-md">
';

$perRow = 2;
$counter = 0;
$number = $this->redux['number-mobile-hamian'];

if (isset($this->redux['slideshow-hamian']) && !empty($this->redux['slideshow-hamian'])) {
	foreach((array)$this->redux['slideshow-hamian'] as $slider ) {
	
	$counter++;
	if ($number >=$counter) {

$imgurl =  $this->placeholdit(100,100);
if ($slider['image'] !=="") { 
$imgurl = wp_get_attachment_image_src( $slider['attachment_id'], 'thumb-100' ); 
$imgurl = $imgurl[0]; 
}

//$title
$title = 'Logo company';
if ($slider['title'] !=="") { $title = $slider['title']; }

$export .='
<div class="col-xs-6 bottom-sm">
<div class="box-hamkar text-center">';
if ($slider['url'] !=="") { $export .='<a href="'.$slider['url'].'" title="'.$title.'" target="_blank" rel="nofollow">'; }
$export .='<img src="'.$imgurl.'" alt="'.$title.'">';
if ($slider['url'] !=="") { $export .='</a>'; }
$export .='
</div>
</div>';

if($counter % $perRow == 0 && $counter != 0) { $export .='<div class="clearfix"></div>'."\n"; }

		}
	}
}


$export .='
</div>

<div id="carousel-hamkaran" class="carousel slide hidden-sm hidden-xs" data-ride="carousel">
<!-- Wrapper for slides -->
<div class="carousel-inner">
';

///
$perRow = 6;
$counter = 0;
$export .='<div class="item active"><div class="row">'."\n"; //First

if (isset($this->redux['slideshow-hamian']) && !empty($this->redux['slideshow-hamian'])) {
	foreach((array)$this->redux['slideshow-hamian'] as $slider ) {

	
if($counter % $perRow == 0 && $counter != 0) {
$export .='
</div>
</div>
<div class="item"><div class="row">'."\n"; 
}
$counter++;
	

$imgurl =  $this->placeholdit(100,100);
if ($slider['image'] !=="") { 
$imgurl = wp_get_attachment_image_src( $slider['attachment_id'], 'thumb-100' ); 
$imgurl = $imgurl[0]; 
}

//$title
$title = 'Logo company';
if ($slider['title'] !=="") { $title = $slider['title']; }

	
$export .='
<div class="col-md-2">
<div class="box-hamkar text-center">';
if ($slider['url'] !=="") { $export .='<a href="'.$slider['url'].'" title="'.$title.'" rel="nofollow">'; }
$export .='<img src="'.$imgurl.'" alt="'.$title.'"'.($slider['title'] !=="" ? ' data-toggle="tooltip" data-placement="top" title="'.$slider['title'].'"' : '').'>';
if ($slider['url'] !=="") { $export .='</a>'; }

$export .='
</div>
</div>';

	}
}

$export .='</div></div>'."\n"; //End first
///


$export .='											
</div>
		</div>
	
	</div>
	
	
</div>

</div>
</div>
<div class="clearfix"></div>
';

	
	/*Setting Show*/
	echo $export;
}

















//****************************************************************************************/
//سیستم گرید سایت
//****************************************************************************************/
/*check AFC Page*/
public function afc_check() {
if (is_page() || is_single()){
if (get_field("layout") =="yes"){ return true; } else { return false; }
}
}


/*show sidebar*/
public function aside($col_sidebar) {
	echo '<div class="'.$col_sidebar.'" id="sidebar">';
	do_action('sidebar-action');
	dynamic_sidebar( 'sidebar-right-widgets' );
	echo '</div>';
}

/*Grid System*/
public function grid($show = 'header') {
	
//**********************************===================== Check Left Sidebar is Show
$col_main = 'col-md-9';
$col_sidebar = 'col-md-3';
$echo_left_sidebar = true;
$aside_place = $this->redux['sidebar-place']; //if:1 =right


//if ($this->afc_check()) { if(get_field("sidebar-layout") ==2) { $echo_left_sidebar =false; } }
//Home
//if (is_home()) { if($this->redux['sidebar-layout-home'] ==2) { $echo_left_sidebar = false; } } //Home

//Category
if (is_category()) { 
if($this->redux['sidebar-layout-category'] ==2) { $echo_left_sidebar = false; } 
$cat_array = explode(',', $this->redux['sidebar-layout-category-not-id']);
if ( is_category( $cat_array ) ) {
if($this->redux['sidebar-layout-category'] ==2) { $echo_left_sidebar = true; } else { $echo_left_sidebar = false; }
}
}

//search
if (is_search()) { if($this->redux['sidebar-layout-search'] ==2) { $echo_left_sidebar = false; } }

//Archive
if (is_archive()) { if($this->redux['sidebar-layout-archive'] ==2) { $echo_left_sidebar = false; } }

//Single or page
if ($this->afc_check()) { 
if(get_field("sidebar-layout") ==2) { $echo_left_sidebar = false; }
$aside_place = get_field("sidebar-place");
}


//**********************************=====================
if ($echo_left_sidebar ===false) {
$col_main = 'col-md-12';
}

//Header
if ($show =="header") {
echo '<div class="container main">';
do_action('content-action');
echo '
<!--Bread Crumb-->
<div class="col-md-12">
<div class="breadcrumb-div">';
bootstrap_breadcrumbs($this->redux['title-home-breadcrumbs']);
echo '
</div>
</div>
<div class="clearfix"></div>';

if ($echo_left_sidebar ===true and $aside_place ==1) {
	$this->aside($col_sidebar);
}

echo '<div class="'.$col_main.'" id="content">';
}


//footer
if ($show =="footer") {	

echo '</div>';

if ($echo_left_sidebar ===true and $aside_place ==2) {
	$this->aside($col_sidebar);
}

echo '</div><div class="clearfix"></div>';

}


}	

//****************************************************************************************/
//دستورات وردپرس
//****************************************************************************************/
public function Panel($type,$icon = '',$title = '',$h1 ='h3',$href='',$extraclass = '') {

$wow = array(1 => 'Up',2 => 'Down',3 => 'Right',4 => 'Left');
$rand_keys = array_rand($wow, 1);
$rand_keys2 = array_rand($wow, 1);

if ($icon =='') { $icon = 'fa-list-alt';}
//<div class="panel-body wow fadeIn'.$wow[$rand_keys2].'" data-wow-delay="1.2s">

if ($type =='start') {
	//<div class="panel panel-default wow fadeIn'.$wow[$rand_keys].'">
echo '
<div class="panel panel-default">
  <div class="panel-heading">
  <'.$h1.' class="panel-title wow fadeInUp" data-wow-delay="1s">'.($href !=="" ? '<a href="'.$href.'" title="'.$title.'">' : '').'<i class="fa '.$icon.'"></i> '.$title.''.($href !=="" ? '</a>' : '').'</'.$h1.'>
  </div>
  <div class="panel-body">
  <div class="matn'.$extraclass.'">';
}

if ($type =='end') {
echo '
<div class="clearfix"></div>
</div><!--Matn-->
</div>
</div>';
}

}


public function Single_Section($title) {
return '
<!--single Sevtion-->
<div class="single-information col-lg-4 col-md-5 col-xs-6 wow fadeInLeft" data-wow-delay="1.2s">'.$title.'</div>
<div class="clearfix"></div>
<div class="single-information-seprate" data-sr></div>
';
}

//***************************Loop View
public function LoopViewThumbail($type,$date ='no',$minitext ='yes',$vipcolor ='',$a ='') {

if ($type =='start') { echo '<ul class="ul-list h-tab-list">'."\n"; }

if ($type =='loop') {
	
$img = $this->placeholdit(120,120);
if ( has_post_thumbnail() ) {
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumb-120');
$img = $thumb[0];
}

//Get Original Date
$postd = get_post( get_the_ID() );

//limit Content
$field = $this->wp_strip_text(get_the_content());

$character = 210;
//$field =  wp_strip_all_tags(strip_shortcodes(get_the_content()));
if (mb_strlen($field) >=$character) { $moref =" .."; } else { $moref=""; }

//Limit title
$tcharacter = 76;
$tfield =  wp_strip_all_tags(strip_shortcodes(get_the_title()));
if (mb_strlen($tfield) >=$tcharacter) { $mored =" .."; } else { $mored=""; }

//extra
$extra = '';
if (get_field("time-audio-blog") !=="") {
$extra .= '<span class="timnum"><i class="fa fa-clock-o"></i> مدت زمان : `'.per_number(get_field("time-audio-blog")).'</span>';
}

if (get_field("show-nazar") =="بله") {
	$comments_count = wp_count_comments(get_the_ID());
	//if ($comments_count->approved >0) {
		$extra .= '<span class="commet-num"><i class="fa fa-comments-o"></i> نظرات ('.per_number($comments_count->approved).')</span>';
	//}
}

$wow_effect = array(1 => 'Up',2 => 'Down',3 => 'Right',4 => 'Left');
$rand_wow = array_rand($wow_effect, 1);
//<li class="wow fadeIn'.$wow_effect[$rand_wow].'" data-wow-delay="1s">

echo '
<li>
	<div class="pull-right"><img src="'.$img.'" alt="'.get_the_title().'"></div>
	<a class="'.$a.' wow fadeInDown" data-wow-delay="1s" href="'.get_permalink($post->ID).'" title="'.get_the_title().'">'.mb_substr($tfield, 0, $tcharacter).$mored.' '.(get_field("vip") =="بله" ? '<span class="label label-'.$vipcolor.'" style="vertical-align: middle;">ویژه</span>' : '').'</a>
	<time datetime="'.$postd->post_date.'"><i class="fa fa-calendar-o"></i> '.get_the_time('l j F Y', $post->ID).'</time>';
	if ($extra !=='') {
		echo $extra;
	}
	echo '
	<p>'.mb_substr($field, 0, $character).$moref.'</p>
	<div class="clearfix"></div>
</li>
';	

}
if ($type =='end') { echo '</ul><div class="clearfix"></div>'; }
}


//***************************Loop Product
public function LoopViewProduct($type) {

if ($type =='start') { echo '<ul class="ul-list h-tab-list-product">'."\n"; }

if ($type =='loop') {
	
$img = $this->placeholdit(250,250);
if ( has_post_thumbnail() ) {
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumb-250');
$img = $thumb[0];
}

//Get Original Date
$postd = get_post( get_the_ID() );


//Limit title
$tcharacter = 83;
$tfield =  wp_strip_all_tags(strip_shortcodes(get_the_title()));
if (mb_strlen($tfield) >=$tcharacter) { $mored =" .."; } else { $mored=""; }

$wow_effect = array(1 => 'Up',2 => 'Down',3 => 'Right',4 => 'Left');
$rand_wow = array_rand($wow_effect, 1);


//product
if(is_post_product(get_the_ID()) ===true) {
$price = '<span class="wow fadeInDown price-show" data-wow-delay="1.2s"><i class="fa fa-shopping-basket"></i> قیمت پستی محصول : '.$this->product_price(get_field('post-price')).' تومان</span>';
} else {
$it = show_item_price_dl_product(get_the_ID());
$price = '<span class="wow fadeInDown price-show" data-wow-delay="1.2s" dir="rtl"><i class="fa fa-shopping-basket"></i> قیمت '.$it['name'].' : '.$this->product_price($it['price']).' تومان</span>';
}

//How to Get
$how_to_get = '';
if(is_post_product(get_the_ID()) ===true) { $how_to_get .= 'پست مرسوله '; }
if(is_dl_product(get_the_ID()) ===true and is_post_product(get_the_ID()) ===true) { $how_to_get .= ', '; }
if(is_dl_product(get_the_ID()) ===true) { $how_to_get .= 'دریافت لینک دانلود'; }

//worksheet
$worksheet = '';
if(is_worksheet_product($_POST['productid']) ===true) {
	$worksheet .='<span class="pworksheet"><i class="fa fa-pencil-square-o"></i> تمرینات عملی (Worksheet)</span>';
}

//<li class="col-md-4 wow fadeIn'.$wow_effect[$rand_wow].'">
echo '
<li class="col-md-4">
	<img src="'.$img.'" alt="'.get_the_title().'">
	<div class="product-inf">
	<a class="wow fadeInLeft" data-wow-delay="1.2s" href="'.get_permalink($post->ID).'" title="'.get_the_title().'">'.mb_substr($tfield, 0, $tcharacter).$mored.'</a>
	'.$price.'
	<span class="how-to-get"><i class="fa fa-cubes"></i> نحوه ی دریافت : '.$how_to_get.'</span>
	'.$worksheet.'
	</div>
	<div class="col-sm-6 text-center wow fadeInRight">
		<a class="btn btn-success field-pro" href="#" data-basket="'.get_the_ID().'" alt="افزودن به سبد خرید"><i class="fa fa-shopping-cart"></i> '.$this->redux['add-to-c'].'</a>
	</div>
	<div class="col-sm-6 text-center wow fadeInLeft">
		<a class="btn btn-default field-pro sepid" href="'.get_permalink($post->ID).'" title="'.get_the_title().'" role="button"><i class="fa fa-file-text-o"></i> اطلاعات محصول</a>
	</div>
	<div class="clearfix"></div>
</li>
';	

}
if ($type =='end') { echo '</ul><div class="clearfix"></div>'; }
}


public function LoopView($type,$icon='fa-caret-left',$time='yes') {

if ($type =='start') { echo '<ul class="ul-list loop-view">'."\n"; }

if ($type =='loop') {
	
	
	
//Get Original Date
$postd = get_post( get_the_ID() ); 

//limit title
$tcharacter = 80;
$tfield =  wp_strip_all_tags(strip_shortcodes(get_the_title()));
if (mb_strlen($tfield) >=$tcharacter) { $mored =" .."; } else { $mored=""; }

$wow = array(1 => 'success',2 => 'primary',3 => 'danger');
$rand_keys = array_rand($wow, 1);

$wow_effect = array(1 => 'Up',2 => 'Down',3 => 'Right',4 => 'Left');
$rand_wow = array_rand($wow_effect, 1);

$extra = '';
//Foroshgah
if (in_category( 5, get_the_ID() )) {
	
$icon = 'fa-shopping-basket';
if(is_post_product(get_the_ID()) ===true) {
$price = '<span class="wow fadeInDown" data-wow-delay="1.2s">قیمت پستی محصول : '.$this->product_price(get_field('post-price')).' تومان</span>';
} else {
$it = show_item_price_dl_product(get_the_ID());
$price = '<span class="wow fadeInDown" data-wow-delay="1.2s" dir="rtl">قیمت '.$it['name'].' : '.$this->product_price($it['price']).' تومان</span>';
}
$extra = $price;
}

//padkast
if (in_category( 4, get_the_ID() )) {
	$icon = 'fa-microphone';
	$extra = 'مدت زمان : `'.per_number(get_field("time-audio-blog")).'';
}
//film
if (in_category( 7, get_the_ID() )) {
	$icon = 'fa-video-camera';
	$extra = 'مدت زمان : `'.per_number(get_field("time-audio-blog")).'';
}
//<li class="wow fadeIn'.$wow_effect[$rand_wow].'" data-wow-delay="1.2s">
echo '
<li>
<i class="fa '.$icon.'"></i> <a href="'.get_permalink($post->ID).'" title="'.get_the_title().'">'.mb_substr($tfield, 0, $tcharacter).$mored.' '.(get_field("vip") =="بله" ? '<span class="label label-'.$wow[$rand_keys].'" style="vertical-align: middle;">ویژه</span>' : '').'</a>';
if ($extra !=='') {
echo '<span class="priv">['.$extra.']</span>';
} else {
echo '<time datetime="'.$postd->post_date.'">['.get_the_time('l j F Y', $post->ID).']</time>';
}
echo '
<div class="clearfix"></div>
</li>
';
}
if ($type =='end') { echo '</ul>'; }
}


//*******************************************Contact page
public function ContactPage() {
	
/*Form*/
echo '
<style>
form.wpcf7-form input { margin:0px; padding:0px; }
form.wpcf7-form input,form.wpcf7-form textarea { width:100% !important; }
form.wpcf7-form textarea { height:100px; }
form.wpcf7-form input[type=submit] { width:35% !important; height:35px; border:0px; transition:1s all; } 
form.wpcf7-form input[type=submit]:hover { background-color:#16191C !important; color:#fff; } 

/*if placeholder for input*/
input[name="your-name"] {
    margin-top: 10px !important;
}
.wpcf7-form input[type="text"], .wpcf7-form input[type="email"] {
    padding: 3px !important;
    margin-top: 0px;
}
.co-social-link {
    text-align: left;
    font-size: 23px;
    margin-top: 15px;
    margin-bottom: -10px;
}
.co-social-link a { margin-left:15px; color:#4B4B4B !important; }
#map { min-height:610px !important; }
</style>
';

echo '<div class="col-md-6" id="right-contact">';


echo '<div class="row hidden-lg hidden-md visible-sm visible-xs" style="margin-top:15px;">'.$this->Single_Section("فرم تماس با ما").'</div>';
//$export .= get_field("form-contact-desc");
echo do_shortcode($this->redux['contact-7-shortcode']);
echo "</div>";

/*Field*/
echo '<div class="col-md-6" style="margin-top:15px;">';

echo '<div class="row hidden-lg hidden-md visible-sm visible-xs" style="margin-bottom:5px;">'.$this->Single_Section("اطلاعات تماس").'</div>';

if ($this->redux['tel-co'] !=="") {
echo '<div class="row Contact-Detail">';
echo '<span class="con-title"><i class="fa fa-phone"></i> تلفن تماس : </span><span class="en-text" style=" direction:ltr !important;" dir="ltr">'.$this->redux['tel-co'].'</span>';
echo '</div>';
}

if ($this->redux['email-co'] !=="") {
echo '<div class="row Contact-Detail">';
echo '<span class="con-title"><i class="fa fa-envelope"></i> پست الکترونیک : </span><span class="en-text" style=" direction:ltr !important;" dir="ltr">'.$this->redux['email-co'].'</span>';
echo '</div>';
}

echo '<div class="ltr co-social-link">';

if ($this->redux['co-rss-link'] !=="") { echo  '<a href="'.$this->redux['co-rss-link'].'" title="Rss"><i class="fa fa-rss"></i></a>'; }
if ($this->redux['co-googleplus-link'] !=="") { echo  '<a href="'.$this->redux['co-googleplus-link'].'" target="_blank" title="Google plus"><i class="fa fa-google-plus"></i></a>'; }
if ($this->redux['co-facebook-link'] !=="") { echo  '<a href="'.$this->redux['co-facebook-link'].'" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>'; }
if ($this->redux['co-twitter-link'] !=="") { echo  '<a href="'.$this->redux['co-twitter-link'].'" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>'; }
if ($this->redux['co-instagram-link'] !=="") { echo  '<a href="'.$this->redux['co-instagram-link'].'" target="_blank" title="instagram"><i class="fa fa-instagram"></i></a>'; }
if ($this->redux['co-telegram-link'] !=="") { echo  '<a href="'.$this->redux['co-telegram-link'].'" target="_blank" title="Telegram"><i class="fa fa-paper-plane"></i></a>'; }

echo '</div>';


echo '<div class="row Contact-Detail" style="margin-top:10px;">';
echo '<span class="con-title"><i class="fa fa-money"></i> مشخصات بانکی : </span><br>';
the_content();
echo '</div>';

if ($this->redux['site-co'] !=="") {
echo '<div class="row Contact-Detail">';
echo '<span class="con-title"><i class="fa fa-user-circle"></i> مدیر مسئول : </span>'.$this->redux['site-co'].'';
echo '</div>';
}

echo "</div>";

/*end*/
echo '<div class="clearfix"></div>';
}

//*********************************************Tag List
public function tag_list() {
	
if (has_tag()) {

$posttags = get_the_tags();
echo $this->Single_Section($this->redux['title-tag-single']);

	if ($posttags) {
	echo'<div id="tag" class="wow fadeInDown" data-wow-delay="1.2s"><ul>';
	foreach($posttags as $tag) { echo '<li><a href="'.get_tag_link($tag->term_id).'" title="'.$tag->name.'">'.$tag->name.'</a></li>'; }
	echo "</ul></div>";
		}

	}	
}


//*************************************************Post information
public function PostInformation() {
	
if (($this->redux['signle-check']['5'] ==0) and ($this->redux['signle-check']['6'] ==0) and ($this->redux['signle-check']['8'] ==0)){} else {
echo '<div class="well post-footer" style="margin:15px 0 0px 0;" data-sr>';
}

/*Category*/
$categories = get_the_category(); 
foreach($categories as $category) { 
$cat_name = $category->name; 
if($cat_name != 'No Category') 
$category_list = '<a href="'.get_category_link($category->term_id).'">'.$cat_name.'</a> '; 
}

if ($this->redux['signle-check']['3'] ==1) { echo '<div><i class="icon-attach"></i> شناسه خبر : <span><a href="'.get_permalink().'" title="'.get_the_title().'">'.per_number(get_the_id()).'</a></span></div>';  }
if ($this->redux['signle-check']['8'] ==1) { echo '<div><i class="icon-download"></i> تعداد بازدید : <span>'.per_number(the_views(false)).'</span></div>';  }
if ($this->redux['signle-check']['5'] ==1) { echo '<div class="cat_mortabet"><i class="icon-link"></i> مرتبط با : <span>&nbsp;'.$category_list.'</span></div>';  } 
if ($this->redux['signle-check']['6'] ==1) { echo '<div><i class="icon-user"></i> نگارش توسط : <span>'.get_the_author().'</span></div>';  }
	
if (($this->redux['signle-check']['5'] ==0) and ($this->redux['signle-check']['6'] ==0) and ($this->redux['signle-check']['8'] ==0)){} else {
echo '</div><div class="clearfix"></div>';
}
	
}


//***********************End class*/	
}