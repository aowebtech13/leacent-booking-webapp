"use client";
import React, { useActionState, Suspense } from "react";
import { useSearchParams } from "next/navigation";
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
import { resetPasswordAction } from "@/lib/auth/action";
import { isRedirectError } from "@/lib/auth/action-error";

const INITIAL_STATE = { error: null as string | null };

const ResetPasswordForm = () => {
  const searchParams = useSearchParams();
  const token = searchParams.get("token") ?? "";

  const [state, formAction, isPending] = useActionState(
    async (_prev: { error: string | null }, formData: FormData) => {
      try {
        await resetPasswordAction(formData);
      } catch (err: any) {
        if (isRedirectError(err)) throw err;
        if (err?.name === "ActionError") {
          return { error: err.message };
        }
        return { error: err?.message || "Unable to reset your password." };
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
                <div className="form-container">
                  <Form
                    action={formAction}
                    className="app-form rounded-control"
                  >
                    <Row>
                      <Col xs={12}>
                        <div className="mb-5 text-center text-lg-start">
                          <h2 className="text-primary-dark f-w-600">
                            Reset Password
                          </h2>
                          <p>Choose a new password for your account</p>
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
                          <Label for="password">New Password</Label>
                          <Input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter Your New Password"
                            minLength={8}
                            required
                          />
                        </FormGroup>
                      </Col>

                      <Col xs={12}>
                        <FormGroup className="mb-3">
                          <Label for="password_confirmation">
                            Confirm Password
                          </Label>
                          <Input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Repeat Your New Password"
                            minLength={8}
                            required
                          />
                        </FormGroup>
                      </Col>

                      <input type="hidden" name="token" value={token} />

                      {!token && (
                        <Col xs={12}>
                          <Alert color="warning" className="mb-3">
                            This reset link is missing its token. Please request
                            a new reset link.
                          </Alert>
                        </Col>
                      )}

                      <Col xs={12}>
                        <div className="mb-3">
                          <Button
                            color="light-primary"
                            type="submit"
                            className="w-100"
                            disabled={isPending || !token}
                          >
                            {isPending ? (
                              <Spinner size="sm" />
                            ) : (
                              "Reset Password"
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

const ResetPasswordPage = () => (
  <Suspense fallback={<div className="p-4 text-center">Loading…</div>}>
    <ResetPasswordForm />
  </Suspense>
);

export default ResetPasswordPage;
