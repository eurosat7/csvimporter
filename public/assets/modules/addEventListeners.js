export function addEventListeners(element, events, handler) {
    events.forEach(
        (e) => {
            element.addEventListener(e, handler, false);
        }
    );
}

export function addEventListenersAndTrigger(element, events, handler) {
    addEventListeners(element, events, handler);
    handler();
}
