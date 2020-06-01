import { configure, extend } from 'vee-validate';
import {
  required,
  email,
  min,
  max,
  confirmed,
  regex,
  alpha,
  alpha_dash,
  image,
} from 'vee-validate/dist/rules';
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
extend('min', {
  ...min,
  message: '{_field_} may not be less than {length} characters',
});
extend('max', {
  ...max,
  message: '{_field_} may not be greater than {length} characters',
});
extend('confirmed', {
  ...confirmed,
  message: "{_field_} doesn't match.",
});
extend('regex', {
  ...regex,
  message: '{_field_} may contain invalid character(s).',
});
extend('alpha_dash', alpha_dash);
extend('alpha', alpha);
extend('image', image);
