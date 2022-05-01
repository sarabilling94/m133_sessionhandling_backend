import axios from 'axios';
import { Formik } from 'formik';
import { Button, Form, Input, Title2 } from '../../theme';
import './creategroup.css';
import { useEffect, useState } from 'react';
import { FormControl, InputLabel, MenuItem, Select } from '@mui/material';

function CreateGroup(): JSX.Element {
  const [groups, setGroups] = useState([]);
  const [selectedGroupValue, setSelectedGroupValue] = useState("");
  const [message, setMessage] = useState("");

  const onSubmit = name => {
    const obj = {
      name: name
    };

    axios.post('http://localhost/haushaltsapp/Backend/Controllers/creategroup.php', obj, { withCredentials: true })
      .then(res => {
        console.log(res);
        if (res.statusText === "Created") {
          console.log("Group created.");

          window.location.reload();
        }
      })
      .catch(error => {
        console.log("Group hasn't been created.")
      });
  }

  const onInvitationSubmit = name => {
    const obj = {
      receiverName: name,
      groupName: selectedGroupValue
    };

    axios.post('http://localhost/haushaltsapp/Backend/Controllers/insertinvitation.php', obj, { withCredentials: true })
      .then(res => {
        console.log(res.data);
      })
      .catch(error => {
      });
  }

  const getGroups = () => {
    axios.get('http://localhost/haushaltsapp/Backend/Controllers/getgroups.php', { withCredentials: true })
      .then(res => {
        setGroups(res.data);
        console.log(groups);
      })
      .catch(error => {
        //console.log(error.response);
      })
  };

  const deleteGroup = () => {
    //checkOwnerRights(selectedGroupValue);
    const obj = {
      groupName: selectedGroupValue
    };

    axios.post('http://localhost/haushaltsapp/Backend/Controllers/deletegroup.php', obj, { withCredentials: true })
      .then(res => {
        if (res.statusText === "Accepted") {
          console.log("Group deleted");

          window.location.reload();
        }
        else {
          console.log("Owner rights needed to delete group.");
          setMessage("Nur Benutzer mit Besitzerrechten dürfen Gruppen löschen!");
        }
      })
      .catch(error => {
        console.log("Group hasn't been deleted.");
      });
  };

  const handleSelectChange = (e) => {
    setSelectedGroupValue(e.target.value);
    setMessage("");
  };

  useEffect(() => {
    getGroups();
  }, []);

  let selectedGroup;

  return (
    <>
      <Title2 style={{ margin: "12px" }}>Gruppe erstellen</Title2>
      <div style={{ margin: "15px" }}>
        <Formik
          initialValues={{ name: '' }}
          onSubmit={(values, { setSubmitting }) => {
            setTimeout(() => {
              onSubmit(values.name);
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
              <Button type="submit" disabled={isSubmitting}>
                Submit
              </Button>
            </Form>
          )}
        </Formik>
        {groups.length > 0 ?
          <>
            <Title2>Gruppen</Title2>
            <FormControl fullWidth>
              <InputLabel id="selectgroup-label">Gruppen</InputLabel>
              <Select
                labelId="selectgroup-label"
                id="selectgroup"
                value={selectedGroup}
                label="Gruppen"
                onChange={handleSelectChange}
              >
                {
                  groups.map((group, index) => {
                    return (
                      <MenuItem key={index} value={group}>{group}</MenuItem>
                    );
                  })
                }
              </Select>
            </FormControl>
          </>
          : null
        }
        {
          (selectedGroupValue !== "") ?
            <>
              <Title2 style={{ margin: "12px" }}>Ausgewählte Gruppe: {selectedGroupValue}</Title2>
              <Button onClick={deleteGroup}>Gruppe löschen</Button>

              <p>{message}</p>

              <Title2 style={{ margin: "12px" }}>Benutzer einladen</Title2>
              <Formik
                initialValues={{ name: ''}}
                onSubmit={(values, { setSubmitting }) => {
                  setTimeout(() => {
                    onInvitationSubmit(values.name);
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
                    <Button>
                      Einladen
                    </Button>
                  </Form>
                )}
              </Formik>
            </>
            : null
        }
      </div>
    </>
  );
}

export default CreateGroup;
