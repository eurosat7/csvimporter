import {addEventListeners} from './addEventListeners.js';
import {ReadyEvents} from './ReadyEvents.js';

export function addOnDocumentChangeCallback(callback) {
    addEventListeners(document, ReadyEvents, callback);
    const observer = new MutationObserver(callback);
    observer.observe(document, {childList: true, subtree: false, attributes: false, characterData: false,});
    triggerOnDocumentChangeCallbacks();
}

export function triggerOnDocumentChangeCallbacks() {
    const event = new Event(ReadyEvents.at(0));
    document.dispatchEvent(event);
}
