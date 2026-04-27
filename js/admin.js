document.addEventListener('DOMContentLoaded', function(){
  // fetch admin API and render charts
  const api = window.__ADMIN_API || '/Mpemba/api/admin_data.php';
  fetch(api).then(r=>r.json()).then(data=>{
    if (data.revenue && document.getElementById('revenueChart')) {
      const ctx = document.getElementById('revenueChart').getContext('2d');
      new Chart(ctx,{type:'line',data:{labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],datasets:[{label:'Revenue',data:data.revenue,backgroundColor:'rgba(108,92,231,0.08)',borderColor:'#6c5ce7',tension:0.3,fill:true}]},options:{responsive:true,plugins:{legend:{display:false}}}});
    }
    if (data.revenue && document.getElementById('reportRevenue')) {
      const ctx2 = document.getElementById('reportRevenue').getContext('2d');
      new Chart(ctx2,{type:'bar',data:{labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],datasets:[{label:'Revenue',data:data.revenue,backgroundColor:'#8b5cf6'}]},options:{indexAxis:'x'}});
    }
  }).catch(e=>console.error(e));
});
