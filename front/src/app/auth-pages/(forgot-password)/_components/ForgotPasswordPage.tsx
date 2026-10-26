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
import Image from "next/image";
import { forgotPasswordAction } from "@/lib/auth/action";
import { isRedirectError } from "@/lib/auth/action-error";

const INITIAL_STATE = { error: null as string | null };

const ForgotPasswordPage = () => {
  const [state, formAction, isPending] = useActionState(
    async (_prev: { error: string | null }, formData: FormData) => {
      try {
        await forgotPasswordAction(formData);
      } catch (err: any) {
        if (isRedirectError(err)) throw err;
        if (err?.name === "ActionError") {
          return { error: err.message };
        }
        return { error: err?.message || "Unable to send the reset link." };
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
                      src="/images/login/03.png"
                      alt="background"
                      className="img-fluid"
                      width={648}
                      height={625}
                      sizes="(max-width: 992px) 100vw, 50vw"
                      priority
                    />
                  </div>
                </div>
              </Col>
              <Col lg={6} className="form-contentbox">
                <div className="d-lg-none text-center mb-3">
                  <Image
                    src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png"
                    alt="logo"
                    width={160}
                    height={93}
                    priority
                  />
                </div>
                <div className="form-container">
                  <Form
                    action={formAction}
                    className="app-form rounded-control"
                  >
                    <Row>
                      <Col xs={12}>
                        <div className="mb-5 mt-5 text-center text-lg-start">
                          <h2 className="text-primary-dark f-w-600">
                            Forgot Password?
                          </h2>
                          <p>
                            Enter your email to receive a password reset link
                          </p>
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

                      <Col xs={12}>
                        <div className="mb-3">
                          <Button
                            color="light-primary"
                            type="submit"
                            className="w-100"
                            disabled={isPending}
                          >
                            {isPending ? (
                              <Spinner size="sm" />
                            ) : (
                              "Send Reset Link"
                            )}
                          </Button>
                        </div>
                      </Col>

                      <Col xs={12} className="text-center text-lg-start mt-3">
                        Remember your password?{" "}
                        <Link
                          href="/auth-pages/sign-in"
                          className="link-primary text-decoration-underline ms-1"
                        >
                          Sign in
                        </Link>
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

export default ForgotPasswordPage;
