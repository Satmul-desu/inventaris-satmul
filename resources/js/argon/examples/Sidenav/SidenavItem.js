/**
=========================================================
* Argon Dashboard 2 MUI - v3.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-material-ui
* Copyright 2023 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
*/

import { useState, useEffect } from "react";

// react-router-dom components
import { useLocation, NavLink } from "react-router-dom";

// prop-types is a library for typechecking of props
import PropTypes from "prop-types";

// @mui material components
import ListItem from "@mui/material/ListItem";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import Icon from "@mui/material/Icon";

// Argon Dashboard 2 MUI components
import ArgonBox from "components/ArgonBox";
import ArgonTypography from "components/ArgonTypography";

// Custom styles for the SidenavItem
import { item, itemIcon, itemText, itemIconActive } from "./styles";

function SidenavItem({ icon, name, active, noCollapse }) {
  const [controller] = useArgonController();
  const { miniSidenav, darkSidenav } = controller;

  return (
    <ListItem component="li">
      <ArgonBox
        component={NavLink}
        to="#"
        sx={(theme) => item(theme, { active, miniSidenav })}
      >
        <ListItemIcon sx={({ palette }) => icon(theme, { active, darkSidenav })}>
          {icon}
        </ListItemIcon>
        <ListItemText
          primary={
            <ArgonTypography
              variant="button"
              fontWeight={active ? "bold" : "regular"}
              color={active ? "primary" : "text"}
              sx={{ textTransform: "none" }}
            >
              {name}
            </ArgonTypography>
          }
        />
      </ArgonBox>
    </ListItem>
  );
}

// Setting default values for the props of SidenavItem
SidenavItem.defaultProps = {
  icon: <Icon>circle</Icon>,
  active: false,
  noCollapse: false,
};

// Typechecking props for the SidenavItem
SidenavItem.propTypes = {
  icon: PropTypes.node,
  name: PropTypes.string.isRequired,
  active: PropTypes.bool,
  noCollapse: PropTypes.bool,
};

export default SidenavItem;

