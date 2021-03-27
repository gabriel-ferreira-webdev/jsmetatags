<?php

# Author     : Projetando Web
# Criado em  : 13 março de 2019
# Website    : https://www.projetandoweb.com.br

defined( '_JEXEC' ) or die();

use Joomla\CMS\Factory;
class plgSystemJsMetatags extends JPlugin
{
	function onBeforeCompileHead(){
                //verificação se está no frontend
		if(JFactory::getApplication()->isAdmin()){return true;}

		$doc = JFactory::getDocument();
		$input = JFactory::getApplication()->input;

		// should be article, categories, featured, blog...
		$view = $input->get('view');


                //Declaração e busca de algumas variaveis do joomla.
		$description = $doc->getMetaData('description');

					$title = JFactory::getApplication()->getMenu()->getActive()->title;
		$url = JURI::base();
		$url_current = JURI::current();
		$sitename = JFactory::getApplication()->getCfg('sitename');



		if ($view == "article") {
			$articleId = JRequest::getInt('id');


			$db = JFactory::getDBO();

			$sql = "SELECT images FROM #__content WHERE id = ".intval($articleId);
			$db->setQuery($sql);
			$fullArticle = $db->loadResult();
		$sql = "SELECT title FROM #__content WHERE id = ".intval($articleId);
		$db->setQuery($sql);
					$title = $db->loadResult();

			$images  = json_decode($fullArticle);
			if (isset($images->image_intro) and !empty($images->image_intro))
			{
			  $timage= htmlspecialchars(JURI::root().$images->image_intro);
			}
			 elseif (isset($images->image_fulltext) and !empty($images->image_fulltext))
			{
			   $timage= htmlspecialchars(JURI::root().$images->image_fulltext);
			 }
			else
			{
			  $timage= 'https://onegreatworknetwork.com/images/ogwn/ogwn-card.jpg';
			}
			$doc->addCustomTag( '
				<meta name="twitter:title" content="'.$title.'">
				<meta name="twitter:text:title" content="'.$title.'">
				<meta name="twitter:card" content="summary_large_image">
				<meta name="twitter:url" content="'.str_replace('" ','&quot;',JURI::current()).'"="">
				<meta name="twitter:image" content="'.$timage.'">
				<meta property="og:title" content="'.$title.'"/>
				<meta property="og:image:alt" content="'.$title.'"/>
				<meta property="og:type" content="article"/>
				<meta property="og:url" content="'.str_replace('" ','&quot;',juri::current()).'"="">
				<meta property="og:image" content="'.$timage.'"/>
				<meta property="og:site_name" content="One Great Work Network"/>
			');
		}elseif ($view == "category") {
				 $doc->addCustomTag( '
				   <meta name="twitter:title" content="'.$title.' - One Great Work Network">
				   <meta name="twitter:text:title" content="'.$title.' - One Great Work Network">
				   <meta name="twitter:card" content="summary_large_image">
				   <meta name="twitter:url" content="'.str_replace('" ','&quot;',JURI::current()).'"="">
				   <meta property="og:title" content="'.$title.' - One Great Work Network"/>
				   <meta property="og:image:alt" content="'.$title.'"/>
				   <meta property="og:type" content="profile"/>
				   <meta property="og:url" content="'.str_replace('" ','&quot;',juri::current()).'"="">
				 	<meta property="og:image:width" content="580" />
				   <meta property="og:site_name" content="One Great Work Network"/>
				   <meta property="fb:admins" content="xxxxxxxxxxx"/>
				 ');
		}else {

		  $menuname = Factory::getApplication()->getMenu()->getActive()->title;
		  		$doc = JFactory::getDocument();
		  $doc->addCustomTag( '
		<meta property="og:title" content="'.$menuname.' - One Great Work Network"/>
		<meta name="twitter:title" content="'.$menuname.' - One Great Work Network">
		<meta name="twitter:text:title" content="'.$menuname.' - One Great Work Network">
		');

							 $doc->addCustomTag( '

			<meta name="twitter:image" content="https://onegreatworknetwork.com/images/ogwn/ogwn-card.jpg">
			  <meta property="og:image" content="https://onegreatworknetwork.com/images/ogwn/ogwn-card.jpg"/>
			  	  <meta name="twitter:card" content="summary_large_image">

			          	  <meta property="og:type" content="website"/>
			          	  <meta property="og:description" content="One Great Work Network - Ending Slavery, One Mind At A Time."/>
														  <meta property="og:url" content="'.str_replace('" ','&quot;',juri::current()).'"="">
							 ');

		}
		return true;
       }
}
?>
