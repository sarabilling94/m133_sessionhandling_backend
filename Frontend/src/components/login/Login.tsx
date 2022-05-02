import './login.css';
import axios from 'axios';
import { Formik } from 'formik';
import { Form, Input, Title2, Button } from "../../theme.js";
import { useNavigate } from "react-router-dom";
import { useState } from 'react';

function Login(): JSX.Element {
  const [message, setMessage] = useState("");

    const onSubmit = (name, password) => {
        const obj ={
        name:name,
        password:password,
        };
         
          axios.post('http://localhost/haushaltsapp/Backend/Controllers/users/login.php',obj, { withCredentials: true })
          .then(res=> {
            console.log(res);
            if(res.statusText === "OK"){
              console.log("Login successful.");
              routeChange();
            }
          })
          .catch(error => {
            console.log(error.response)
            if(error.response.statusText === "Forbidden"){
              setMessage("Benutzername oder Passwort ist falsch.");
            }
        });
    }

  let navigate = useNavigate();
  const routeChange = () =>{
      let path = '/Home';
      navigate(path);
      window.location.reload(); 
  }

  return (
  <>
  <Title2 style={{ margin:"12px" }}>Login</Title2>
    <div style={{ margin:"15px" }}>
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
    <p>{message}</p>
    </div>
</>
  );
}

export default Login;
