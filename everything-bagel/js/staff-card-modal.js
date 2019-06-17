// Staff Card Modal

console.log('Staff Card Modal');

function moveModals() {

     let modals = document.getElementsByClassName('clb-custom-modal-move');
     //console.log(modals);

     for (var i = 0; i < modals.length; i++) {
          //console.log(modals[i]);

          // copy and create new modal down in footer where the functionality will work
          let newModal = document.createElement("div");
          newModal.innerHTML = modals[i].innerHTML;
          document.body.appendChild(newModal);

          // wipe out the modal HTML in the entry-content
          modals[i].innerHTML = '';
     }

}


moveModals();
