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

// prop-types is a library for typechecking of props
import PropTypes from "prop-types";

// @mui material components
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";

function DefaultFooter({ content, light, ...rest }) {
  const year = new Date().getFullYear();

  return (
    <Box {...rest} component="footer" sx={{ py: 3, px: 2 }}>
      {content}
      <Box display="flex" justifyContent="center" alignItems="center">
        <Typography
          variant="button"
          fontWeight="regular"
          color={light ? "white" : "text"}
          sx={{ textDecoration: "none" }}
        >
          &copy; {year}, made with
        </Typography>
        <Box fontSize="1.25rem" color={light ? "white" : "dark"}>
          &nbsp;❤&nbsp;
        </Box>
        <Typography
          variant="button"
          fontWeight="regular"
          color={light ? "white" : "text"}
          sx={{ textDecoration: "none" }}
        >
          by Creative Tim
        </Typography>
      </Box>
    </Box>
  );
}

// Setting default values for the props of DefaultFooter
DefaultFooter.defaultProps = {
  content: "",
  light: false,
};

// Typechecking props for the DefaultFooter
DefaultFooter.propTypes = {
  content: PropTypes.node,
  light: PropTypes.bool,
};

export default DefaultFooter;

