import {model} from './src/model.js';
import {view} from './src/view.js';
import {controller} from './src/controller.js';


window.addEventListener('DOMContentLoaded', function() {
   
    // model, view, controller 선언
    const schedule_modal = model();
    const schedule_view = view(schedule_modal);
    const schedule_controller = controller(schedule_modal, schedule_view);
});