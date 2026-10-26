"use client";
import React, { useActionState, useState } from "react";
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
import Image from "next/image";

import { registerUser } from "@/lib/auth/action";
import { isRedirectError } from "@/lib/auth/action-error";

const INITIAL_STATE = { error: null as string | null };

const SignUpPage = () => {
  const [state, formAction, isPending] = useActionState(
    async (_prev: { error: string | null }, formData: FormData) => {
      try {
        await registerUser(formData);
      } catch (err: any) {
        if (isRedirectError(err)) throw err;
        if (err?.name === "ActionError") {
          return { error: err.message };
        }
        return { error: err?.message || "Registration failed" };
      }
      return INITIAL_STATE;
    },
    INITIAL_STATE
  );

  // Local form state to retain input values on validation errors.
  const [formValues, setFormValues] = useState({
    username: "",
    email: "",
    password: "",
    confirmPassword: "",
    phone: "",
    terms: false,
  });

  const handleChange = (
    e: React.ChangeEvent<
      HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement
    >
  ) => {
    const { name, type, value, checked } = e.target as HTMLInputElement;
    setFormValues((prev) => ({
      ...prev,
      [name]: type === "checkbox" ? (checked ?? false) : value,
    }));
  };

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
                      <Image
                        src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png"
                        alt="logo"
                        className="img-fluid"
                        width={201}
                        height={111}
                        priority
                      />
                    </span>
                  </div>
                  <div className="signup-bg-img">
                    <Image
                      src="/images/login/02.png"
                      alt="signup"
                      className="img-fluid"
                      width={648}
                      height={624}
                      sizes="(max-width: 992px) 100vw, 50vw"
                      priority
                    />
                  </div>
                </div>
              </Col>
              <Col lg={6} className="form-contentbox">
                <div className="form-container">
                  <Form
                    action={formAction}
                    className="app-form rounded-control"
                  >
                    <Row>
                      <Col xs={12}>
                        <div className="mb-5 mt-5 text-center text-lg-start">
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
                            value={formValues.username}
                            onChange={handleChange}
                            placeholder="Enter Your Username"
                            required
                            autoComplete="username"
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
                            value={formValues.email}
                            onChange={handleChange}
                            placeholder="Enter Your Email"
                            required
                            autoComplete="email"
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
                            value={formValues.password}
                            onChange={handleChange}
                            placeholder="Enter Your Password"
                            required
                            autoComplete="new-password"
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
                            value={formValues.confirmPassword}
                            onChange={handleChange}
                            placeholder="Enter Your Password"
                            required
                            autoComplete="new-password"
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
                            value={formValues.phone}
                            onChange={handleChange}
                            placeholder="Enter Your Phone"
                            autoComplete="tel"
                          />
                        </FormGroup>
                      </Col>

                      <Col xs={12}>
                        <FormGroup check className="mb-3">
                          <Input
                            type="checkbox"
                            id="checkDefault"
                            name="terms"
                            className="form-check-input"
                            checked={formValues.terms}
                            onChange={handleChange}
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
