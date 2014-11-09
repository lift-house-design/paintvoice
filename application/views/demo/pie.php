<div style="padding:50px;position:relative;overflow:visible">

<div id="pie-wrap2">
	<div id="pie-wrap">
		<div id="pie">
			<div style="height:148px"></div>
			<input style="width:200px"/><br/>
			<input style="width:150px"/><br/>
			<input type="submit" style="width:100px"/>
		</div>
	</div>
</div>

<div id="box" onclick="toggle_pie()">login</div>
</div>

<script>
function toggle_pie(){
	$('#pie').toggleClass('out');
	$('#pie-wrap').toggleClass('out');
	$('#pie-wrap2').toggleClass('out');
}
</script>

<style>
#pie.out{
	/*
    transform:rotate(0deg); 
    -webkit-transform:rotate(0deg); 
    -moz-transform:rotate(0deg); 
    -o-transform:rotate(0deg);
	background:green;
	*/
}
#pie-wrap.out{
    transform:rotate(0deg); 
    -webkit-transform:rotate(0deg); 
    -moz-transform:rotate(0deg); 
    -o-transform:rotate(0deg);
}
#box{
	background: blue;
	width:135px;
	height:50px;
	position:absolute;
	top:0px;
	left:185px;
}
#pie{
	border-radius:99999px;
	background: blue;
	width:270px;
	height:270px;
	position:absolute;
	top:-135px;
	text-align:center;
}
#pie-wrap2{
	overflow:hidden;
	width:135px;
	height:135px;
	position:absolute;
	top:50px;
	left:185px;
    -webkit-transition: all 0.15s ease-in-out;
	-webkit-transition-delay: 0.3s;
}
#pie-wrap2.out{
	width:270px;
	left:50px;
	-webkit-transition-delay: 0s !important;
}
#pie-wrap{
	position:absolute;
	top:0px;
	right:0px;
	height:135px;
	width:270px;
	overflow:hidden;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    transform:rotate(-180deg); 
    -webkit-transform:rotate(-180deg); 
    -moz-transform:rotate(-180deg); 
    -o-transform:rotate(-180deg);
    -webkit-transform-origin: 135px 0px;
}

#content-wrap{overflow: visible;}
</style>