<?php
/**
 * 
 * @author              Duong Dinh Thien<thiendd@peacesoft.net> 
 * @package 		System SaoBang.vn
 * @version 		1.0
 * @since 		
 * @copyright 		PeaceSoft (c) 2012
 *
 */
$catId = isset($_GET['catId']) ? $_GET['catId'] : 0;
$childCat = isset($_GET['childCat']) ? $_GET['childCat'] : 0;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if ($this->keyword) {
    $keyword = $this->keyword;
} elseif (Yii::app()->cache->get($keyword)) {
    $keyword = Yii::app()->cache->get($keyword);
} else {
    $keyword = 'Ví dụ: iphone cũ giá rẻ..';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="<?php echo SERVER_DATA; ?>/themes/homepage/style/reset.css?v=29" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo SERVER_DATA; ?>/themes/homepage/style/grid_12.css?v=29" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo SERVER_DATA; ?>/themes/homepage/style/style.css?v=18" media="all" />
        <script type="text/javascript" src="<?php echo SERVER_DATA; ?>/themes/homepage/scripts/jquery.min.js?v=29"></script>
        <script type="text/javascript" src="<?php echo SERVER_DATA; ?>/themes/homepage/scripts/saobang.js?v=02"></script>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/themes/facebok/facebox.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/facebok/facebox.js" type="text/javascript"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('a[rel*=facebox]').facebox({
                    loadingImage : '<?php echo Yii::app()->request->baseUrl; ?>/themes/facebok/loading.gif',
                    closeImage   : '<?php echo Yii::app()->request->baseUrl; ?>/themes/facebok/closelabel.png'
                })
            })
        </script>
        <?php echo Yii::app()->params['googleAnalytics']; ?>
    </head>
    <body>  	
        <div id="header">
            <div class="tophead">
                <div class="main newyear-event clearfix">
                    <a class="logoRv beta" href="<?php echo Yii::app()->createUrl('home/index'); ?>"></a>
                    <div class="Navi-tophead">
                        <ul class="clearfix">
                            <li <?php if (Yii::app()->controller->action->id != 'published') echo 'class="active"'; ?>>
                                <a href="<?php echo Yii::app()->createUrl('home/search'); ?>"><span><b>Tìm kiếm</b></span></a>
                            </li>
                            <li <?php if (Yii::app()->controller->action->id == 'published') echo 'class="active"'; ?>>
                                <a href="<?php echo Yii::app()->createUrl('home/published'); ?>"><span><b>Tin đã đăng</b></span></a>
                            </li>
                        </ul>
                    </div>
                    <?php echo Yii::app()->params['contact']; ?>
                    <?php $this->widget('zii.widgets.CMenu', GlobalComponents::homepageMenu()); ?>	
                    <div class="postNews-Rv"><a href="<?php echo Yii::app()->createUrl('topic/step1'); ?>">Đăng rao vặt</a></div>
                </div>
            </div>
            <div class="browse-head">
                <div class="main clearfix">
                    <div class="locationRv" id="dropLocal">
                        <a class="slted" href="javascript:void(0);">
                            <?php
                            echo ExtensionClass::getCurrentLocality();
                            ?>
                        </a>
                        <div id="_dropLocal" class="none">
                            <div class="sub-sltbox">
                                <div class="scroll-auto inner-sub-sltbox">
                                    <?php $this->widget('zii.widgets.CMenu', ExtensionClass::homepageLocality()); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->beginWidget('CActiveForm', array('id' => 'searchHomepage', 'method' => 'get', 'action' => Yii::app()->createUrl('home/search'))); ?>
                    <div class="textcap1">Tôi muốn tìm</div>
                    <div class="boxsearch">
                        <span class="corner-left"></span>
                        <span class="corner-right"></span>
                        <input class="search-head" type="text" name="keyword" id="headSeach" value="<?php echo $keyword; ?>" />
                    </div>
                    <div class="textcap2">Trong</div>
                    <div class="categsearch">
                        <a class="slted" id="categorySeachValue" href="javascript:void(0);">
                            <?php
                            if ($childCat) {
                                echo ExtensionClass::getCurrentCategory($childCat);
                            } elseif ($catId) {
                                echo ExtensionClass::getCurrentCategory($catId);
                            } else {
                                echo 'Tất cả danh mục';
                            }
                            ?>
                        </a>
                        <input type="hidden" name="catId" value="<?php echo $catId; ?>" id="categorySeach" />
                        <input type="hidden" name="childCat" value="<?php echo $childCat; ?>" id="childCatSeach" />
                        <div class="w250 h295 sub-sltbox none" id="_catSvalue">
                            <div class="scroll-auto inner-sub-sltbox h295">
                                <?php $this->widget('zii.widgets.CMenu', ExtensionClass::homepageCategory()); ?>
                            </div>
                        </div>
                    </div>
                    <a class="submit-head" onclick="searchContent();" href="javascript:void(0);">Tìm ngay</a>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>    
        <div id="wrapper">
            <div class="main clearfix"> 
                <?php echo Yii::app()->params['ad700x90']; ?>                
                <?php echo $content; ?>            
            </div>
        </div>

        <div id="footer">
            <div class="main clearfix">
                <div class="fl"><span class="regis-TMDT"></span></div>
                <div class="fr">
                    <h4><?php echo Yii::app()->params['copyright']; ?></h4>
                    <?php $this->widget('zii.widgets.CMenu', GlobalComponents::homepageFooter()); ?>
                    <div class="clearfix">
                        <div class="ft-col">
                            <p>
                                <?php echo Yii::app()->params['hanoiaddress']; ?>
                            </p>
                            <?php echo GlobalComponents::footerLinkLeft(); ?>
                        </div>
                        <div class="ft-col">
                            <p>
                                <?php echo Yii::app()->params['saigonaddress']; ?>
                            </p>
                            <?php echo GlobalComponents::footerLinkRight(); ?>
                        </div>
                    </div>

                </div>
                <?php echo Yii::app()->params['chat']; ?>
                <?php echo Yii::app()->params['popnet']; ?>

            </div>
        </div>
        <div style="background: #4e585d">
            <div class="footerLink"><?php GlobalComponents::extensionFooterLink(); ?></div>
            <style type="text/css">
                .footerLink{margin: auto; width: 980px;}
                .footerLink a{color: #839198; padding: 0px 5px;}
            </style>
        </div>
        <a class="to-top" onclick="gotoTop()" href="javascript:void(0)"></a>
        <script type="text/javascript">
            function gotoTop(){
                $('html, body').animate({ scrollTop: 0 }, 'slow');
            }        
        </script>
    </body>
</html>

