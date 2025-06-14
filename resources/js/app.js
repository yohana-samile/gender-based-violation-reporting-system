import './bootstrap';
import TomSelect from 'tom-select';

new TomSelect('#service_ids', {
    plugins: ['remove_button'],
    maxItems: null,
    create: false,
});
