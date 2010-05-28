<?php
if (!defined('BLOCK_FILE')) {
 Header("Location: ../index.php");
 exit;
}

global $tracker_lang;

$blocktitle = $tracker_lang['news'].(get_user_class() >= UC_ADMINISTRATOR ? "<font class=\"small\"> - [<a class=\"altlink\" href=\"news.php\"><b>".$tracker_lang['create']."</b></a>]</font>" : "");

$resource = sql_query("SELECT news.* , COUNT(newscomments.id) AS numcomm FROM news LEFT JOIN newscomments ON newscomments.news = news.id WHERE ADDDATE(news.added, INTERVAL 45 DAY) > NOW() GROUP BY news.id ORDER BY news.added DESC LIMIT 3") or sqlerr(__FILE__, __LINE__);


if (mysql_num_rows($resource)) {
    $content .= "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\"><tr><td class=\"text\">\n<ul>";
    while($array = mysql_fetch_array($resource)) {
		if ($news_flag == 0) {
$content .=
      "<div class=\"news-wrap\"><div class=\"news-head folded clickable unfolded\"><table width=100% border=0 cellspacing=0 cellpadding=0><tr><td class=bottom width=50%><i>".date("d.m.Y",strtotime($array['added']))."</i> - <b>".$array['subject']."</b></td></tr></table></div><div style=\"display: block;\" class=\"news-body\">".format_comment($array['body']);
      $content .="<hr/><div align=\"right\">";
      			if (get_user_class() >= UC_ADMINISTRATOR) {
		        $content .= "[<a href=\"news.php?action=edit&newsid=" . $array['id'] . "&returnto=" . urlencode($_SERVER['PHP_SELF']) . "\"><b>E</b></a>]";
		        $content .= "[<a href=\"news.php?action=delete&newsid=" . $array['id'] . "&returnto=" . urlencode($_SERVER['PHP_SELF']) . "\"><b>D</b></a>] ";
      }
      			$content .= "������������: ".$array['numcomm']." [<a href=\"newsoverview.php?id=".$array['id']."\">��������������</a>]</div>";
      $content .= "</div></div>";
	    	$news_flag = 1;
    	} else {
		$content .=
      "<div class=\"news-wrap\"><div class=\"news-head folded clickable\"><table width=100% border=0 cellspacing=0 cellpadding=0><tr><td class=bottom width=50%><i>".date("d.m.Y",strtotime($array['added']))."</i> - <b>".$array['subject']."</b></td></tr></table></div><div class=\"news-body\">".format_comment($array['body']);
      $content .="<hr/><div align=\"right\">";
      			if (get_user_class() >= UC_ADMINISTRATOR) {
		        $content .= "[<a href=\"news.php?action=edit&newsid=" . $array['id'] . "&returnto=" . urlencode($_SERVER['PHP_SELF']) . "\"><b>E</b></a>]";
		        $content .= "[<a href=\"news.php?action=delete&newsid=" . $array['id'] . "&returnto=" . urlencode($_SERVER['PHP_SELF']) . "\"><b>D</b></a>] ";
      }
      			$content .= "������������: ".$array['numcomm']." [<a href=\"newsoverview.php?id=".$array['id']."\">��������������</a>]</div>";
      $content .= "</div></div>";
    	}
	}
	$content .= "<p align=\"right\">[<a href=\"newsarhive.php\">����� ��������</a>]</p></ul></td></tr></table>\n";
} else {
	$content .= "<table class=\"main\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\"><tr><td class=\"text\">";
	$content .= "<div align=\"center\"><h3>".$tracker_lang['no_news']."</h3></div>\n";
	$content .= "</td></tr></table>";
}

?>