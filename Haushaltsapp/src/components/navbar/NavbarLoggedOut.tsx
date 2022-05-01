import * as React from 'react';
import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import Link from '@mui/material/Link';
import IconButton from '@mui/material/IconButton';
import { Title } from "../../theme.js";
import logout from "../utils/logout";

export default function Navbar2() {

  return (
    <Box sx={{ flexGrow: 1 }}>
      <AppBar position="static">
          <Toolbar>
            <IconButton
              size="large"
              edge="start"
              color="inherit"
              aria-label="menu"
              sx={{ mr: 2 }}
            >
            </IconButton>
            <Title>Haushaltsapp</Title>
            <div style={{ width: "800px" }}></div>
            <Link href="/register" sx={{ flexGrow: 0.1 }} color="inherit">Registrieren</Link>
            <Link onClick={logout} href="/" sx={{ flexGrow: 0.1 }} color="inherit">Login</Link>
          </Toolbar>
      </AppBar>
    </Box>
  );
}
