{set-block scope=root variable=cache_ttl}0{/set-block}
{if and(is_set($display_tags),eq($display_tags,true()))}
	<script src="/mdgoogleanalytics/script.js" type="text/javascript" charset="utf-8"></script>
{else}
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '{$google_account}']);
	_gaq.push(['_trackPageview']);
	_gaq.push(['_trackPageLoadTime']);
	/**
	 * For Google Adsense Integration
	 */
	window.google_analytics_uacct = '{$google_account}';
	{literal}
	(function() 
	{
		var ga = document.createElement('script'); 
		ga.type = 'text/javascript'; 
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script').item(0);
		if(s && s.parentNode) 
			s.parentNode.insertBefore(ga, s);
  	})();{/literal}
  	{literal}
  	function initGaLinks()
  	{
  		var links = document.getElementsByTagName('a');
  		var nbLinks = links.length;
	  	for(var i=0;i<nbLinks;i++)
	  	{
	  		var link = links.item(i);
	  		try
	  		{
	  			if(link && link.href && link.href != null && link.href != undefined && link.href != '')
	  			{
	  				var href = link.href;
	  				if(href.substring(0,1) != '/' && href.lastIndexOf(location.protocol + '//' + location.hostname) != 0 && !href.match(/Javascript/i))
	  				{
	  					var onclick = link.getAttribute('onclick');
	  					onclick = "_gaq.push(['_trackEvent','outbound',this.className?this.className:'External-link',this.href]);" + (typeof onclick == 'string'?onclick:'');
	  					link.setAttribute('onclick',onclick);
	  				}
	  			}
	  		}
	  		catch(e){}
	  	}
	}
	setTimeout('initGaLinks()',3000);
  	{/literal}
{/if}