/* AERA Studio — logo animado + altímetro */
(function(){
    var header=document.getElementById('site'), brand=document.getElementById('brand');
    var boxes=[].slice.call(brand.querySelectorAll('.lbox'));
    var altFill=document.getElementById('altFill'), altMk=document.getElementById('altMk'), altN=document.getElementById('altN');
    function lerp(a,b,t){return a+(b-a)*t;}
    function update(){
      var y=window.scrollY||window.pageYOffset||0;
      var p=Math.min(y/260,1), big=40, small=32, size=lerp(big,small,p), gap=lerp(7,5,p), step=size+gap, diagOff=lerp(size*0.60,0,p);
      boxes.forEach(function(b,i){ b.style.width=size+'px'; b.style.height=size+'px'; b.style.fontSize=lerp(20,17,p).toFixed(1)+'px';
        b.style.transform='translate('+lerp(i*(size*0.72),i*step,p).toFixed(1)+'px,'+lerp(i*diagOff,0,p).toFixed(1)+'px)'; });
      brand.style.height=lerp(40+3*(40*0.60),small,p).toFixed(0)+'px'; brand.style.width=lerp(40+3*(40*0.72),3*(small+5)+small,p).toFixed(0)+'px';
      if(y>24) header.classList.add('scrolled'); else header.classList.remove('scrolled');
      var max=(document.documentElement.scrollHeight-window.innerHeight)||1, prog=Math.min(Math.max(y/max,0),1);
      altFill.style.height=(prog*100)+'%'; altMk.style.top=(prog*100)+'%'; altN.textContent=Math.round((1-prog)*120);
    }
    var t=false; window.addEventListener('scroll',function(){ if(!t){ requestAnimationFrame(function(){update();t=false;}); t=true; } },{passive:true});
    window.addEventListener('resize',update,{passive:true}); update();
  })();
