"use strict";!function(){const e=document.querySelector(".cancel-subscription");e&&(e.onclick=function(){Swal.fire({text:"Are you sure you would like to cancel your subscription?",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-outline-secondary waves-effect"},buttonsStyling:!1}).then((function(e){e.value?Swal.fire({icon:"success",title:"Unsubscribed!",text:"Your subscription cancelled successfully.",customClass:{confirmButton:"btn btn-success waves-effect"}}):e.dismiss===Swal.DismissReason.cancel&&Swal.fire({title:"Cancelled",text:"Unsubscription Cancelled!!",icon:"error",customClass:{confirmButton:"btn btn-success waves-effect"}})}))});const t=document.querySelector(".edit-address"),n=document.querySelector(".address-title"),s=document.querySelector(".address-subtitle");t.onclick=function(){n.innerHTML="Edit Address",s.innerHTML="Edit your current address"}}();
