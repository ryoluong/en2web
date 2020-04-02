import { configure, extend } from 'vee-validate';
import { required, email, max } from 'vee-validate/dist/rules';
const config = {
  // mode: 'lazy',
};

configure(config);

extend('required', {
  ...required,
  message: '{_field_} is required',
});
extend('email', {
  ...email,
  message: 'This field must be a valid email',
});
extend('max', {
  ...max,
  message: '{_field_} may not be greater than {length} characters',
});
