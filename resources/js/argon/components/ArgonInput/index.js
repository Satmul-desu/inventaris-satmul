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

import { forwardRef } from "react";

// prop-types is a library for typechecking of props
import PropTypes from "prop-types";

// Custom styles for ArgonInput
import ArgonInputRoot from "components/ArgonInput/ArgonInputRoot";

const ArgonInput = forwardRef(
  ({ size, error, success, icon, ...rest }, ref) => (
    <ArgonInputRoot
      {...rest}
      ref={ref}
      ownerState={{ size, error, success, icon }}
    />
  )
);

// Setting default values for the props of ArgonInput
ArgonInput.defaultProps = {
  size: "medium",
  error: false,
  success: false,
  icon: false,
};

// Typechecking props for the ArgonInput
ArgonInput.propTypes = {
  size: PropTypes.oneOf(["small", "medium", "large"]),
  error: PropTypes.bool,
  success: PropTypes.bool,
  icon: PropTypes.bool,
};

export default ArgonInput;

