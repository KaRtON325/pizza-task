import { object, string, number } from "yup";

const loginFormSchema = object().shape({
    first_name: string().required().max(255),
    last_name: string().required().max(255),
    email: string().required().email(),
    phone_number: string().required().max(255),
    country: string().required().min(3).max(255),
    state: string().required().min(3).max(255),
    city: string().required().max(255),
    street: string().required().min(5).max(255),
    currency_id: number().integer().required(),
});

export default loginFormSchema