import './register.css';
import axios from 'axios';
import { Formik } from 'formik';
import { Form, Input, Title2, Button } from "../../theme.js";

function Register(): JSX.Element {
  const onSubmit = (name, password) => {
    const obj = {
      name: name,
      password: password,
    };

    axios.post('http://localhost/haushaltsapp/Backend/Controllers/insertuser.php', obj)
      .then(res => console.log(res.data))
      .catch(error => {
        console.log(error.response)
      });
  }

  return (
    <>
    <Title2 style={{ margin:"12px" }}>Registrieren</Title2>
      <div style={{ margin: "15px" }}>
        <Formik
          initialValues={{ name: '', password: '' }}
          onSubmit={(values, { setSubmitting }) => {
            setTimeout(() => {
              onSubmit(values.name, values.password);
              setSubmitting(false);
            }, 400);
          }}
        >
          {({
            values,
            errors,
            touched,
            handleChange,
            handleBlur,
            handleSubmit,
            isSubmitting,
          }) => (
            <Form onSubmit={handleSubmit}>
              <Input
                type="name"
                name="name"
                onChange={handleChange}
                onBlur={handleBlur}
                value={values.name}
              />
              <Input
                type="password"
                name="password"
                onChange={handleChange}
                onBlur={handleBlur}
                value={values.password}
              />
              {errors.password && touched.password && errors.password}
              <Button type="submit" disabled={isSubmitting}>
                Submit
              </Button>
            </Form>
          )}
        </Formik>
      </div>
    </>
  );
}

export default Register;
