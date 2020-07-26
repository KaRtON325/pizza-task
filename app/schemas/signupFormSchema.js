import * as yup from "yup";

const loginFormSchema = yup.object().shape({
    email: yup.string().required().email(),
    password: yup.string().required().min(6),
    password_confirm: yup.string().oneOf([yup.ref('password'), null]).required(),
});

export default loginFormSchema