import React, { useState, useEffect } from "react";
import Select from "react-select";

interface SelectProps {
  options: { value: string; label: string }[];
  placeholder: string;
  defaultValue: string[];
  instanceId?: string;
}

const MultiSelect: React.FC<SelectProps> = ({
  options,
  placeholder,
  defaultValue,
  instanceId = "multi-select",
}) => {
  const [selectedOptions, setSelectedOptions] = useState<
    { value: string; label: string }[]
  >([]);

  useEffect(() => {
    const newSelectedOptions = options.filter((option) =>
      defaultValue.includes(option.value)
    );

    if (
      JSON.stringify(newSelectedOptions) !== JSON.stringify(selectedOptions)
    ) {
      setSelectedOptions(newSelectedOptions);
    }
  }, [defaultValue, options]);

  const handleChange = (selected: any) => {
    setSelectedOptions(selected || []);
  };

  return (
    <Select
      instanceId={instanceId}
      isMulti
      options={options}
      value={selectedOptions}
      onChange={handleChange}
      placeholder={placeholder}
      classNamePrefix="custom-select"
    />
  );
};

export default MultiSelect;
