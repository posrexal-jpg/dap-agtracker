"serviceWorker"in navigator&&(window.addEventListener("load",function(){navigator.serviceWorker.register("/sw.js").then(function(e){console.log("Service Worker registered successfully with scope:",e.scope),e.addEventListener("updatefound",function(){const n=e.installing;n.addEventListener("statechange",function(){n.state==="installed"&&navigator.serviceWorker.controller&&o()})})}).catch(function(e){console.log("Service Worker registration failed:",e)})}),navigator.serviceWorker.addEventListener("controllerchange",function(){window.location.reload()}));function o(){const e=document.createElement("div");e.style.cssText=`
        position: fixed;
        top: 20px;
        right: 20px;
        background: #1e3a8a;
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 9999;
        font-family: 'Public Sans', sans-serif;
        max-width: 300px;
        cursor: pointer;
    `,e.innerHTML=`
        <div style="font-weight: 600; margin-bottom: 5px;">App Updated!</div>
        <div style="font-size: 14px;">Click to refresh and get the latest features.</div>
    `,e.onclick=function(){window.location.reload()},document.body.appendChild(e),setTimeout(()=>{e.parentNode&&e.remove()},1e4)}window.addEventListener("online",function(){console.log("App is online")});window.addEventListener("offline",function(){console.log("App is offline")});
