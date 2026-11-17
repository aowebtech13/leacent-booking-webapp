"use client";
import React, { useState } from "react";
import {
  Card,
  CardHeader,
  CardBody,
  Form,
  FormGroup,
  Label,
  Input,
  Button,
  Alert,
  Spinner,
} from "reactstrap";
import { changePassword } from "@/lib/api/auth";
import toast from "@/Component/Services/toast";

const EMPTY_FORM = {
  current_password: "",
  new_password: "",
  new_password_confirmation: "",
};

const ChangePasswordForm = () => {
  const [formData, setFormData] = useState(EMPTY_FORM);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [success, setSuccess] = useState(false);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const validate = (): string | null => {
    if (
      !formData.current_password ||
      !formData.new_password ||
      !formData.new_password_confirmation
    ) {
      return "Please fill in all password fields.";
    }
    if (formData.new_password.length < 8) {
      return "New password must be at least 8 characters.";
    }
    if (formData.new_password !== formData.new_password_confirmation) {
      return "New password and confirmation do not match.";
    }
    if (formData.new_password === formData.current_password) {
      return "New password must be different from your current password.";
    }
    return null;
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setError(null);
    setSuccess(false);

    const validationError = validate();
    if (validationError) {
      setError(validationError);
      return;
    }

    setSaving(true);
    try {
      await changePassword({
        current_password: formData.current_password,
        new_password: formData.new_password,
        new_password_confirmation: formData.new_password_confirmation,
      });
      setFormData(EMPTY_FORM);
      setSuccess(true);
      toast.success("Password updated successfully.");
    } catch (err: any) {
      const message = err?.message || "Failed to update password.";
      setError(message);
      toast.error(message);
    } finally {
      setSaving(false);
    }
  };

  return (
    <Card className="setting-profile-tab">
      <CardHeader>
        <h5>Reset Password</h5>
      </CardHeader>
      <CardBody>
        <Form className="app-form" onSubmit={handleSubmit}>
          {error && (
            <Alert color="danger" className="mb-3">
              {error}
            </Alert>
          )}
          {success && (
            <Alert color="success" className="mb-3">
              Password updated successfully!
            </Alert>
          )}

          <p className="text-secondary mb-4">
            Enter your current password and choose a new one.
          </p>

          <FormGroup>
            <Label>Current Password</Label>
            <Input
              type="password"
              name="current_password"
              value={formData.current_password}
              onChange={handleChange}
              placeholder="Enter your current password"
              autoComplete="current-password"
            />
          </FormGroup>

          <FormGroup>
            <Label>New Password</Label>
            <Input
              type="password"
              name="new_password"
              value={formData.new_password}
              onChange={handleChange}
              placeholder="At least 8 characters"
              autoComplete="new-password"
            />
          </FormGroup>

          <FormGroup>
            <Label>Confirm New Password</Label>
            <Input
              type="password"
              name="new_password_confirmation"
              value={formData.new_password_confirmation}
              onChange={handleChange}
              placeholder="Re-enter your new password"
              autoComplete="new-password"
            />
          </FormGroup>

          <Button
            type="submit"
            color="primary"
            className="mt-2"
            disabled={saving}
          >
            {saving ? (
              <>
                <Spinner size="sm" className="me-2" />
                Updating...
              </>
            ) : (
              "Update Password"
            )}
          </Button>
        </Form>
      </CardBody>
    </Card>
  );
};

export default ChangePasswordForm;
