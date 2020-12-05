<?php
require __DIR__ . '/jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
require_once APP_ROOT . '/jp-includes/app/functions.php';
require_once APP_ROOT . '/jp-includes/app/siteinfo.php';
header('Content-type: application/json'); ?>
{
  "@context":"https://schema.org","@graph":[{
  "@type":"Organization","@id":"<?php echo BASE_URL; ?>/#organization","name":"TekstLab","url":"<?php echo BASE_URL; ?>/",
    <?php
    if (!empty($fbPage) || !empty($twitterPage) || !empty($igPage) || !empty($ytPage) || !empty($spotifyProfile) || !empty($liPage) || !empty($taPage)) {
      echo '"sameAs":[';
      echo !empty($fbPage) ? '"' . $fbPage . '"' : '"null"';
      echo !empty($twitterPage) ? ',"' . $twitterPage . '"' : '';
      echo !empty($igPage) ? ',"' . $igPage . '"' : '';
      echo !empty($ytPage) ? ',"' . $ytPage .'"' : '';
      echo !empty($spotifyProfile) ? ',"' . $spotifyProfile . '"' : '';
      echo !empty($liPage) ? ',"' . $liPage . '"' : '';
      echo !empty($taPage) ? ',"' . $taPage . '"' : '';
      echo '],' . "\r\n";
    } ?>
    "logo":{
      "@type":"ImageObject","@id":"<?php echo BASE_URL; ?>/#logo","inLanguage":"<?php echo $lang; ?>","url":"<?php echo BASE_URL; ?>/assets/img/site/site-logo.svg","width":600,"height":138,"caption":"<?php echo $metaPageTitle; ?>"
    },"image":{
      "@id":"<?php echo BASE_URL; ?>/#primaryimage"
    }
  },{
    "@type":"WebSite","@id":"<?php echo BASE_URL; ?>/#website","url":"<?php echo BASE_URL; ?>/","name":"<?php echo $metaPageTitle; ?>","description":"<?php echo strip_tags($pageDesc); ?>","publisher":{
      "@id":"<?php echo BASE_URL; ?>/#organization"
    },"potentialAction":[{
      "@type":"SearchAction","target":"<?php echo BASE_URL; ?>/?s={search_term_string}","query-input":"required name=search_term_string"
      }],"inLanguage":"<?php echo $lang; ?>"
    },{
      "@type":"ImageObject","@id":"<?php echo BASE_URL; ?>/#primaryimage","inLanguage":"nb-NO","url":"<?php echo BASE_URL . $featuredImage; ?>","width":<?php echo $featuredImageWidth; ?>,"height":<?php echo $featuredImageHeight; ?>
    },{
      "@type":"WebPage","@id":"<?php echo BASE_URL; ?>/#webpage","url":"<?php echo BASE_URL; ?>/","name":"<?php echo $metaPageTitle; ?>","isPartOf":{
        "@id":"<?php echo BASE_URL; ?>/#website"
      },"about":{
        "@id":"<?php echo BASE_URL; ?>/#organization"
      },"primaryImageOfPage":{
        "@id":"<?php echo BASE_URL; ?>/#primaryimage"
      },"datePublished":"<?php echo $siteCreated; ?>","dateModified":"<?php echo $siteCreated; ?>","inLanguage":"<?php echo $lang; ?>","potentialAction":[{
        "@type":"ReadAction","target":["<?php echo BASE_URL; ?>/"]
      }]
    }]
  }
