"use client";
import React, { useActionState } from "react";
import {
  Col,
  Container,
  Row,
  Form,
  FormGroup,
  Label,
  Input,
  Button,
  Spinner,
  Alert,
} from "reactstrap";
import Link from "next/link";
import {
  IconBrandFacebook,
  IconBrandGithub,
  IconBrandGoogle,
} from "@tabler/icons-react";
import { registerUser } from "@/lib/auth/action";
import { ActionError } from "@/lib/auth/action-error";

const INITIAL_STATE = { error: null as string | null };

const SignUpPage = () => {
  const [state, formAction, isPending] = useActionState(
    async (_prev: { error: string | null }, formData: FormData) => {
      try {
        await registerUser(formData);
      } catch (err: any) {
        if (err?.name === "ActionError") {
          return { error: err.message };
        }
        return { error: err?.message || "Registration failed" };
      }
      return INITIAL_STATE;
    },
    INITIAL_STATE
  );

  return (
    <div className="sign-in-bg">
      <div className="app-wrapper d-block">
        <div className="main-container">
          <Container>
            <Row className="sign-in-content-bg">
              <Col lg={6} className="image-contentbox d-none d-lg-block">
                <div className="form-container">
                  <div className="signup-content mt-4">
                    <span>
                      <img
                        src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png"
                        alt="logo"
                        className="img-fluid"
                      />
                    </span>
                  </div>
                  <div className="signup-bg-img">
                    <img
                      src="/images/login/02.png"
                      alt="signup"
                      className="img-fluid"
                    />
                  </div>
                </div>
              </Col>
              <Col lg={6} className="form-contentbox">
                <div className="form-container">
                  <Form action={formAction} className="app-form rounded-control">
                    <Row>
                      <Col xs={12}>
                        <div className="mb-5 text-center text-lg-start">
                          <h2 className="text-primary-dark f-w-600">
                            Create Account
                          </h2>
                          <p>Get Started For Free Today!</p>
                        </div>
                      </Col>

                      {state.error && (
                        <Col xs={12}>
                          <Alert color="danger" className="mb-3">
                            {state.error}
                          </Alert>
                        </Col>
                      )}

                      <Col xs={12}>
                        <FormGroup className="mb-3">
                          <Label for="username">Username</Label>
                          <Input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Enter Your Username"
                            required
                          />
                        </FormGroup>
                      </Col>

                      <Col xs={12}>
                        <FormGroup className="mb-3">
                          <Label for="email">Email</Label>
                          <Input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter Your Email"
                            required
                          />
                        </FormGroup>
                      </Col>

                      <Col md={6}>
                        <FormGroup className="mb-3">
                          <Label for="password">Password</Label>
                          <Input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter Your Password"
                            required
                          />
                        </FormGroup>
                      </Col>

                      <Col md={6}>
                        <FormGroup className="mb-3">
                          <Label for="confirmPassword">Confirm Password</Label>
                          <Input
                            type="password"
                            id="confirmPassword"
                            name="confirmPassword"
                            placeholder="Enter Your Password"
                            required
                          />
                        </FormGroup>
                      </Col>

                      <Col xs={12}>
                        <FormGroup className="mb-3">
                          <Label for="phone">Phone (Optional)</Label>
                          <Input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="Enter Your Phone"
                          />
                        </FormGroup>
                      </Col>

                      <Col xs={12}>
                        <FormGroup check className="mb-3">
                          <Input
                            type="checkbox"
                            id="checkDefault"
                            className="form-check-input"
                          />
                          <Label
                            check
                            htmlFor="checkDefault"
                            className="form-check-label text-secondary"
                          >
                            Accept Terms & Conditions
                          </Label>
                        </FormGroup>
                      </Col>

                      <Col xs={12}>
                        <div className="mb-3">
                          <Button
                            color="light-primary"
                            type="submit"
                            className="w-100"
                            disabled={isPending}
                          >
                            {isPending ? <Spinner size="sm" /> : "Sign Up"}
                          </Button>
                        </div>
                      </Col>

                      <Col xs={12}>
                        <div className="text-center text-lg-start">
                          Already Have An Account?{" "}
                          <Link
                            href="/auth-pages/sign-in"
                            className="link-primary text-decoration-underline"
                          >
                            Sign in
                          </Link>
                        </div>
                      </Col>

                      <div className="app-divider-v justify-content-center">
                        <p>Or sign up with</p>
                      </div>

                      <Col xs={12}>
                        <div className="text-center">
                          <Button
                            type="button"
                            color="light-primary"
                            className="btn-light-facebook  icon-btn b-r-22 m-1"
                          >
                            <IconBrandFacebook size={18} />
                          </Button>
                          <Button
                            type="button"
                            color="light-primary"
                            className="btn-light-gmail icon-btn b-r-22 m-1"
                          >
                            <IconBrandGoogle size={18} />
                          </Button>
                          <Button
                            type="button"
                            color="light-primary"
                            className="btn-light-github icon-btn b-r-22 m-1"
                          >
                            <IconBrandGithub size={18} />
                          </Button>
                        </div>
                      </Col>
                    </Row>
                  </Form>
                </div>
              </Col>
            </Row>
          </Container>
        </div>
      </div>
    </div>
  );
};

export default SignUpPage;
