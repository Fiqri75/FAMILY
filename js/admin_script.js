let navbar = document.querySelector('.header .flex .navbar');
let userBox = document.querySelector('.header .flex .account-box');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   userBox.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active'); 
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   userBox.classList.remove('active');
}

// Chart JS

document.addEventListener('DOMContentLoaded', function() {
  //  getChartUser();
   getChartUserV2();
   getChartPaymentCompleted();
   getChartUserPremiumOrNon();

});


function getChartUser(){
   fetch(`${baseURL}/api/userChart.php`) 
   .then(response => response.json())
   .then(resp => {

       const data = {
         labels: resp.data.chart.labels,
         datasets: resp.data.chart.datasets,
         backgroundColor: resp.data.chart.backgroundColor,
         borderColor: resp.data.chart.borderColor,
         borderWidth: resp.data.chart.borderWidth
       };
    
        // Konfigurasi chart
        const config = {
         type: 'bar',
         data: data,
         options: {
           scales: {
             y: {
               beginAtZero: true
             }
           }
         },
       };
    
        // Inisialisasi dan render chart
       const myChart = new Chart(
         document.getElementById('chartUser'),
         config
      );
   })
   .catch(error => console.error('Error fetching data:', error));
}

function getChartUserV2(){
  fetch(`${baseURL}/api/userChartV2.php`) 
  .then(response => response.json())
  .then(resp => {

      const data = {
        labels: resp.data.chart.labels,
        datasets: resp.data.chart.datasets,
        backgroundColor: resp.data.chart.backgroundColor,
        borderColor: resp.data.chart.borderColor,
        borderWidth: resp.data.chart.borderWidth
      };
   
       // Konfigurasi chart
       const config = {
         type: 'line',
         data: data,
       };
   
       // Inisialisasi dan render chart
      const myChart = new Chart(
        document.getElementById('chartUser'),
        config
     );
  })
  .catch(error => console.error('Error fetching data:', error));
}

function getChartUserPremiumOrNon(){
   fetch(`${baseURL}/api/userChartPremiumOrNo.php`) 
   .then(response => response.json())
   .then(resp => {

       const data = {
         labels: resp.data.chart.labels,
         datasets: resp.data.chart.datasets,
         backgroundColor: resp.data.chart.backgroundColor,
         borderColor: resp.data.chart.borderColor,
         borderWidth: resp.data.chart.borderWidth
       };
    
        // Konfigurasi chart
        const config = {
         type: 'doughnut',
         data: data,
         options: {
           scales: {
             y: {
               beginAtZero: true
             }
           }
         },
       };
    
        // Inisialisasi dan render chart
       const myChart = new Chart(
         document.getElementById('chartUserPremiumOrNon'),
         config
      );
   })
   .catch(error => console.error('Error fetching data:', error));
}

function getChartPaymentCompleted(){
   fetch(`${baseURL}/api/paymentChart.php`) 
   .then(response => response.json())
   .then(resp => {

       const data = {
         labels: resp.data.chart.labels,
         datasets: resp.data.chart.datasets,
         backgroundColor: resp.data.chart.backgroundColor,
         borderColor: resp.data.chart.borderColor,
         borderWidth: resp.data.chart.borderWidth
       };
    
        // Konfigurasi chart
        const config = {
          type: 'line',
          data: data,
        };
    
        // Inisialisasi dan render chart
       const myChart = new Chart(
         document.getElementById('chartCompletedPayment'),
         config
      );
   })
   .catch(error => console.error('Error fetching data:', error));
}

