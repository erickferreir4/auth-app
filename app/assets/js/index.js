'use strict';

const Index = {

    __dropdown() {
        let drop = doc.querySelector('#drop-down')

        let closure_ = (ev) => {

            doc.querySelector('.account-drop')
                .classList.toggle('is--active')
        }

        drop.addEventListener('click', closure_, false)
    },


    init() {
        this.__dropdown();
    }
}

Index.init();
