{*
	Smarty Debug Template
	copyright 	2007 Rueegg Tuck Partner GmbH
	author 		Simon Tuck <stu@rtp.ch>
	link 		http://www.rtp.ch/
	package 	smarty
	version 	1.2
*}
{literal}
<style>
	ul.krumo-first{
		border: 0px;
	}
	div.krumo-nest{
		z-index: 2000;
		position: relative;
	}
	div.krumo-expand{
		position: relative;
		z-index: 1900;
	}
</style>
{/literal}

<div style="position: absolute; width: auto; z-index: 1000; display: block;">
    {krumo}
</div>

