BX.addCustomEvent('onTimeManWindowBuild', build);
let button = '';
let observer;

function build () {
        let parentButton = BX.findChild(BX('timeman_main'), {tag: 'div', className: 'tm-popup-button-handler'}, true);
        button = BX.findChild(BX('timeman_main'), {tag: 'button', className: 'ui-btn-icon-start'}, true);
        if (button) {
            let newButton = BX.create({
                tag: 'button',
                props: {'class': 'ui-btn ui-btn-success ui-btn-icon-start'},
                attrs: {'class': 'ui-btn ui-btn-success ui-btn-icon-start'},
                text: button.textContent,
            });
            BX.append(newButton, parentButton);
            BX.style(button, 'display', 'none');
            BX.bind(newButton, "click", open);
        }
            let table = BX.findChild(BX('timeman_main'), {tag: 'td', className: 'tm-popup-timeman-layout-button'}, true);
            observer = new MutationObserver(mutationRecords => {
                check();
            });

            observer.observe(table, {
                childList: true,
                subtree: true,
                characterDataOldValue: true
            });
}

function check () {
    observer.disconnect();
    build();
}

function open (e) {
    var popup = BX.PopupWindowManager.create("popup-message", null, {
        content: '<br><div style="text-align:center;font-size:15px;">Вы уверены что хотите начать?</div>',
        width: 400, // ширина окна
        height: 130, // высота окна
        zIndex: 100, // z-index
        closeIcon: {
            opacity: 1
        },
        closeByEsc: true, // закрытие окна по esc
        darkMode: false, // окно будет светлым или темным
        autoHide: false, // закрытие при клике вне окна
        draggable: true, // можно двигать или нет
        resizable: true, // можно ресайзить
        min_height: 130, // минимальная высота окна
        min_width: 300, // минимальная ширина окна
        lightShadow: true, // использовать светлую тень у окна
        angle: false, // появится уголок
        overlay: {
            backgroundColor: "black",
            opacity: 500
        },
        buttons: [
            new BX.PopupWindowButton({
                text: "Начать", // текст кнопки
                id: "save-btn", // идентификатор
                className: "ui-btn ui-btn-success", // доп. классы
                events: {
                    click: function () {
                        button.click();
                        popup.close();
                    }
                }
            }),
            new BX.PopupWindowButton({
                text: "Отмена",
                id: "copy-btn",
                className: "ui-btn ui-btn-primary",
                events: {
                    click: function () {
                        popup.close();
                    }
                }
            })
        ],
        events: {
            onPopupShow: function () {
                // Событие при показе окна
            },
            onPopupClose: function () {
                // Событие при закрытии окна
            }
        }
    });
    popup.show();
}