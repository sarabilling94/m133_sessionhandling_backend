import { useEffect, useState } from 'react';
import Calendar from 'react-calendar';
import { Button, Form, Input, Title2, Title3 } from '../../theme';
import 'react-calendar/dist/Calendar.css';
import './taskcalendar.css';
import { Formik } from 'formik';
import { MenuItem, Select } from '@mui/material';
import axios from 'axios';

function TaskCalendar(): JSX.Element {
  const [groups, setGroups] = useState([]);
  const [usersOfGroup, setUsersOfGroup] = useState([]);
  const [date, setDate] = useState(new Date());
  const [selectedGroupValue, setSelectedGroupValue] = useState("");
  const [selectedUserValue, setSelectedUserValue] = useState("");

  const onSubmit = (name, checkbox) => {
    console.log("checkbox:", checkbox);

    const obj = {
      task: name,
      group: selectedGroupValue,
      date: date.toISOString().split('T')[0],
      user: selectedUserValue
    };

    console.log(selectedUserValue);

    if (checkbox) {//onetimetask
      axios.post('http://localhost/haushaltsapp/Backend/Controllers/tasks/insertonetimetask.php', obj, { withCredentials: true })
        .then(res => {
          console.log(res.data);
        })
        .catch(error => {
          console.log(error.response);
        });
    }
    else {
      axios.post('http://localhost/haushaltsapp/Backend/Controllers/tasks/inserttask.php', obj, { withCredentials: true })
        .then(res => {
          console.log(res.data);
        })
        .catch(error => {
          console.log(error.response);
        });
    }
  };

  const getGroups = () => {
    axios.get('http://localhost/haushaltsapp/Backend/Controllers/groups/getgroups.php', { withCredentials: true })
      .then(res => {
        setGroups(res.data);
        console.log(groups);
      })
      .catch(error => {
        //console.log(error.response);
      })
  };


  const getUsersOfGroup = (groupName) => {
    const obj = {
      groupName: groupName
    };

    axios.post('http://localhost/haushaltsapp/Backend/Controllers/groups/getusersofgroup.php', obj, { withCredentials: true })
      .then(res => {
        console.log(res.data);
        const currentGroup = res.data;
        setUsersOfGroup(currentGroup.list_groupusers);
        //console.log("usersofgroup: ", currentGroup);
      })
      .catch(error => {
        //console.log(error.response);
      })
  };

  const handleSelectGroupChange = (e) => {
    const groupName = e.target.value;
    setSelectedGroupValue(groupName);
    getUsersOfGroup(groupName);
  };

  const handleSelectUserChange = (e) => {
    setSelectedUserValue(e.target.value);
  };

  useEffect(() => {
    getGroups();
  }, []);

  let selectedGroup;
  let selectedUserOfGroup;

  return (
    <>
      <div className='calendar'>
        <Title2>Kalender</Title2>
        <div className='calendar-container'>
          <Calendar onChange={setDate} value={date} />
        </div>

        <Title3>Aufgabe hinzufügen</Title3>
        <p className='text-center'>
          <span className='bold'>Gewähltes Datum:</span>{' '}
          {date.toDateString()}
        </p>

        {groups.length > 0 ?
          <>
            <Formik
              initialValues={{ name: '', checkbox: false }}
              onSubmit={(values, { setSubmitting }) => {
                setTimeout(() => {
                  onSubmit(values.name, values.checkbox);
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
                  <Select
                    style={{ width: "310px", height: "40px", margin: "10px" }}
                    labelId="selectgroup-label"
                    id="selectgroup"
                    value={selectedGroup}
                    label="Gruppen"
                    onChange={handleSelectGroupChange}
                  >
                    {
                      groups.map((group, index) => {
                        return (
                          <MenuItem key={index} value={group}>{group}</MenuItem>
                        );
                      })
                    }
                  </Select>
                  {selectedGroupValue ?
                  <Select
                    style={{ width: "310px", height: "40px", margin: "10px" }}
                    labelId="selectgroup-label"
                    id="selectuser"
                    value={selectedUserOfGroup}
                    label="Benutzer"
                    onChange={handleSelectUserChange}
                  >
                    { usersOfGroup ?
                    usersOfGroup.map((user, index) => {
                      return (
                        <MenuItem key={index} value={user.username}>{user.username}</MenuItem>
                      );
                    })
                  : null
                  }
                  </Select>
                  : null
                }
                  <Input
                    type="name"
                    name="name"
                    onChange={handleChange}
                    onBlur={handleBlur}
                    value={values.name}
                  />
                  <span className='bold'>Einmalige Aufgabe?</span>{' '}
                  <Input
                    type="checkbox"
                    name="checkbox"
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
          </>
          : null
        }
      </div>
    </>
  );
}

export default TaskCalendar;
