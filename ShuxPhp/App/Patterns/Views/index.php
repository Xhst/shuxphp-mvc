<! DOCTYPE HTML>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<link rel="shortcut icon" href="{{ url }}/Assets/favicon.ico" id="favicon">
<link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ url }}/Assets/css/style.css">
<title>{{ title }}</title>
</head>
<body>
<div class="top"></div>
<main>
<div class="title">
{{ welcome }}: {{ title }}
</div>
<div class="subtitle">
{{ subtitle }}
</div>
<section>
{% if showcode == '1' %}
<div id="box">
<ol class="code">
<li>&lt;?php
<li><span class="key">namespace</span> ShuxPhp\App\MVC\Controllers
<li>{
<li>&nbsp;&nbsp;&nbsp;&nbsp;<span class="key">use</span> ShuxPhp\App\{<span class="keycn">Utility</span> <span class="key">as</span> <span class="keyg">Utility</span>, <span class="keycn">Configuration</span> <span class="key">as</span> <span class="keyg">config</span>};
<li>&nbsp;&nbsp;&nbsp;&nbsp;<span class="key">use</span> ShuxPhp\App\Routing\{<span class="keycn">IRoutable</span>, <span class="keycn">ControllerManager</span>}
<li>
<li>&nbsp;&nbsp;&nbsp;&nbsp;<span class="key">class</span> <span class="keycn">Index</span> <span class="key">extends</span> <span class="keycn">ControllerManager</span> <span class="key">implements</span> <span class="keycn">IRoutable</span>
<li>&nbsp;&nbsp;&nbsp;&nbsp;{
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="key">public function</span> <span class="keycn">Index</span>()
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$index = <span class="keycf">parent::</span><span class="keyg">Model</span>(<span class="keyc">'Index'</span>);
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="keycf">parent::</span><span class="keyg">View</span>(<span class="keyc">'index'</span>,
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="keyc">'showcode'</span> <span class="keycf">=></span> <span class="keynum">1</span>
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]);
<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
<li>&nbsp;&nbsp;&nbsp;&nbsp;}
<li>}
</ol>
</div>
{% endif %}
</section>
</main>
<main class="submain">
<section>
<form method="post">
	<input type="text">
	<button type="submit">gsag</button>
</form>
</section>
</main>
</body>
</html>